<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SchoolUserController extends Controller
{
    // Método para asignar el administrador
    public function createAdmin(Request $request, $schoolId)
    {
        // Asegurar que la conexión sea la de la base de datos del colegio
        DB::purge('school');
        $this->setSchoolDatabaseConnection($schoolId);

        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email', // Eliminamos la validación 'unique' aquí
            'admin_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verificar manualmente si el email ya existe en la base de datos del colegio
        $emailExists = DB::connection('school')->table('usuarios_colegio')
            ->where('email', $request->admin_email)
            ->exists();

        if ($emailExists) {
            return redirect()->back()->withErrors(['admin_email' => 'El correo electrónico ya está en uso'])->withInput();
        }

        // Insertar al administrador en la tabla 'usuarios_colegio'
        DB::connection('school')->table('usuarios_colegio')->insert([
            'nombre' => $request->admin_name,
            'email' => $request->admin_email,
            'contraseña' => Hash::make($request->admin_password),
            'role_id' => 1, // Asignar rol de administrador
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('schools.configure', $schoolId)->with('success', 'Administrador asignado correctamente');
    }

    // Configurar la conexión de la base de datos del colegio
    private function setSchoolDatabaseConnection($schoolId)
    {
        // Recuperar el subdominio del colegio desde la base de datos principal
        $school = DB::table('schools')->where('id', $schoolId)->first();
        $dbName = 'school_' . $school->subdomain;

        // Configurar la conexión para la base de datos del colegio
        config(['database.connections.school.database' => $dbName]);
        DB::purge('school');
        DB::reconnect('school');
    }
}

