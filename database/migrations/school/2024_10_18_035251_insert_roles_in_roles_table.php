<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class InsertRolesInRolesTable extends Migration
{
    public function up()
    {
        // Forzar la conexión a la base de datos del colegio
        DB::purge('school');
        DB::reconnect('school');

        $currentDatabase = DB::connection('school')->getDatabaseName();

        if ($currentDatabase) {
            Log::info('Conectado a la base de datos: ' . $currentDatabase);

            if (Schema::connection('school')->hasTable('roles')) {
                if (DB::connection('school')->table('roles')->count() == 0) {
                    // Insertar los roles con el valor 'web' en el campo guard_name
                    DB::connection('school')->table('roles')->insert([
                        ['name' => 'Administrador', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
                        ['name' => 'Docente', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
                        ['name' => 'Secretario', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
                        ['name' => 'Estudiante', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
                    ]);
                    Log::info('Roles insertados en la base de datos del colegio.');
                }
            }
        }
    }

    public function down()
    {
        DB::purge('school');
        DB::reconnect('school');

        if (Schema::connection('school')->hasTable('roles')) {
            DB::connection('school')->table('roles')->whereIn('name', ['Administrador', 'Docente', 'Secretario', 'Estudiante'])->delete();
            Log::info('Roles eliminados de la base de datos del colegio.');
        }
    }
}

