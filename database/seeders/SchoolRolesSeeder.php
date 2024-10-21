<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SchoolRolesSeeder extends Seeder
{
    public function run()
    {
        // Cambiar la conexión a la base de datos del colegio
        DB::purge('school');
        DB::reconnect('school');

        // Obtener el nombre de la base de datos actual para confirmar la conexión
        $currentDatabase = DB::connection('school')->getDatabaseName();
        Log::info('Conectado a la base de datos del colegio: ' . DB::connection('school')->getDatabaseName());

        // Verificar si la tabla de roles ya tiene registros
        if (DB::connection('school')->table('roles')->count() == 0) {
            Log::info("Insertando roles en la base de datos del colegio: {$currentDatabase}");

            // Insertar roles con el campo 'guard_name'
            Role::create(['name' => 'Administrador', 'guard_name' => 'web']);
            Role::create(['name' => 'Docente', 'guard_name' => 'web']);
            Role::create(['name' => 'Secretario', 'guard_name' => 'web']);
            Role::create(['name' => 'Estudiante', 'guard_name' => 'web']);

            Log::info("Roles insertados correctamente en la base de datos del colegio: {$currentDatabase}");
        } else {
            Log::info("La tabla de roles ya tiene registros en la base de datos del colegio: {$currentDatabase}");
        }
    }
}

