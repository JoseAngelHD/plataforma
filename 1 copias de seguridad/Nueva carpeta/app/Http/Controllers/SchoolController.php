<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::all();
        return view('schools.index', compact('schools'));
    }

    public function create()
    {
        return view('schools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email',
            'subdomain' => 'required|string|unique:schools,subdomain',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $school = School::create($validated);

        return redirect()->route('schools.index')->with('success', 'Colegio creado con éxito');
    }

    public function edit(School $school)
    {
        return view('schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:schools,email,' . $school->id,
            'subdomain' => 'required|string|unique:schools,subdomain,' . $school->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $school->update($validated);

        return redirect()->route('schools.index')->with('success', 'Colegio actualizado con éxito');
    }

    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('schools.index')->with('success', 'Colegio eliminado con éxito');
    }

    public function configure($id)
    {
        $school = School::findOrFail($id);
        return view('schools.configure', compact('school'));
    }

    private function setSchoolDatabaseConnection($subdomain)
{
    $dbName = 'school_' . $subdomain;

    // Registro de log para verificar la configuración de la conexión
    \Log::info("Configurando la conexión para el colegio con subdominio: $subdomain");

    config(['database.connections.school.database' => $dbName]);
    DB::purge('school');
    DB::reconnect('school');

    // Registro de log para confirmar que la base de datos se configuró correctamente
    \Log::info("Conexión a la base de datos configurada correctamente para: $dbName");
}


    public function createDatabase($id)
    {
        $school = School::findOrFail($id);
        $dbName = 'school_' . $school->subdomain;

        try {
            if (!DB::statement("CREATE DATABASE IF NOT EXISTS $dbName")) {
                return redirect()->route('schools.configure', $school->id)->with('error', 'Error al crear la base de datos');
            }

            return redirect()->route('schools.configure', $school->id)->with('success', 'Base de datos creada correctamente');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->route('schools.configure', $school->id)->with('error', 'Error al crear la base de datos');
        }
    }

    public function createTables($id)
    {
        $school = School::findOrFail($id);
        $this->setSchoolDatabaseConnection($school->subdomain);
    
        try {
            // Registro antes de ejecutar las migraciones
            \Log::info("Iniciando migraciones para el colegio con ID: $id y subdominio: {$school->subdomain}");
    
            // Ejecutar las migraciones para crear las tablas
            Artisan::call('migrate', [
                '--database' => 'school',
                '--path' => 'database/migrations/school',
                '--force' => true,
            ]);
    
            // Ejecutar el seeder de roles
            Artisan::call('db:seed', [
                '--class' => 'InsertRolesInRolesTableSeeder', // Asegúrate de que este seeder existe y está bien configurado
                '--database' => 'school',
            ]);
    
            // Puedes agregar otro seeder aquí si necesitas insertar permisos y relaciones de roles/permisos.
            // Artisan::call('db:seed', [
            //     '--class' => 'PermissionsAndRolesSeeder',
            //     '--database' => 'school',
            // ]);
    
            // Registro de log después de ejecutar las migraciones y seeders
            \Log::info("Migraciones y seeders completados correctamente para el colegio con ID: $id");
    
            return redirect()->route('schools.configure', $school->id)->with('success', 'Tablas creadas correctamente');
        } catch (\Exception $e) {
            // Registro en caso de error
            \Log::error("Error al crear las tablas para el colegio con ID: $id - Error: " . $e->getMessage());
            return redirect()->route('schools.configure', $school->id)->with('error', 'Error al crear las tablas');
        }
    }
    
    

public function createAdmin(Request $request, $id)
{
    $school = School::findOrFail($id);
    $this->setSchoolDatabaseConnection($school->subdomain);

    $validated = $request->validate([
        'admin_name' => 'required|string|max:255',
        'admin_email' => 'required|email|unique:school.users,email',
        'admin_password' => 'required|string|min:8|confirmed',
    ]);

    try {
        if (!Schema::connection('school')->hasTable('users')) {
            return redirect()->route('schools.configure', $school->id)->with('error', 'La tabla de usuarios no existe');
        }

        // Asignar el rol de 'Admin'
        $adminRoleId = DB::connection('school')->table('roles')->where('name', 'Admin')->first()->id;

        DB::connection('school')->table('users')->insert([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make($validated['admin_password']),
            'role_id' => $adminRoleId, // Asignar el rol al administrador
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('schools.configure', $school->id)->with('success', 'Administrador asignado correctamente');
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return redirect()->route('schools.configure', $school->id)->with('error', 'Error al asignar el administrador');
    }
}

    public function addPermissionsTableToExistingSchools()
    {
        $schools = School::all();
        foreach ($schools as $school) {
            $this->setSchoolDatabaseConnection($school->subdomain);

            try {
                DB::connection('school')->getPdo();

                if (!Schema::connection('school')->hasTable('permissions')) {
                    Artisan::call('migrate', [
                        '--database' => 'school',
                        '--path' => 'database/migrations/school/2024_10_07_000002_create_permission_tables.php',
                        '--force' => true,
                    ]);

                    $this->createDefaultRolesAndPermissions();
                    \Log::info("Tablas de permisos y roles creadas en el colegio " . $school->name);
                } else {
                    \Log::info("Las tablas de permisos ya existen en el colegio " . $school->name);
                }
            } catch (\Exception $e) {
                \Log::error("Error al agregar las tablas de permisos al colegio " . $school->name . ": " . $e->getMessage());
            }
        }
    }

    private function createDefaultRolesAndPermissions()
    {
        $permissions = [
            'gestionar usuarios',
            'ver reportes',
            'crear cursos',
            'editar configuraciones',
        ];

        foreach ($permissions as $permission) {
            DB::connection('school')->table('permissions')->insert([
                'name' => $permission,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $roles = [
            'Super Admin',
            'Admin',
            'Usuario',
        ];

        foreach ($roles as $role) {
            DB::connection('school')->table('roles')->insert([
                'name' => $role,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $adminRoleId = DB::connection('school')->table('roles')->where('name', 'Admin')->first()->id;
        $permissionIds = DB::connection('school')->table('permissions')->pluck('id');

        foreach ($permissionIds as $permissionId) {
            DB::connection('school')->table('role_has_permissions')->insert([
                'role_id' => $adminRoleId,
                'permission_id' => $permissionId,
            ]);
        }
    }
}
