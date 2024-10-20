<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class InsertRolesInRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Forzar la conexión a la base de datos del colegio
        DB::purge('school');
        DB::reconnect('school');

        // Obtener el nombre de la base de datos actual para los logs
        $currentDatabase = DB::connection('school')->getDatabaseName();

        // Verificar si estamos conectados a una base de datos válida
        if ($currentDatabase) {
            Log::info('Conectado a la base de datos: ' . $currentDatabase);

            // Verificar si la tabla 'roles' existe en la base de datos del colegio
            if (Schema::connection('school')->hasTable('roles')) {
                Log::info('La tabla roles existe en la base de datos: ' . $currentDatabase);

                // Verificar si la tabla 'roles' ya tiene datos
                if (DB::connection('school')->table('roles')->count() == 0) {
                    // Insertar roles predeterminados si la tabla está vacía
                    DB::connection('school')->table('roles')->insert([
                        ['name' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
                        ['name' => 'Docente', 'created_at' => now(), 'updated_at' => now()],
                        ['name' => 'Secretario', 'created_at' => now(), 'updated_at' => now()],
                        ['name' => 'Estudiante', 'created_at' => now(), 'updated_at' => now()],
                    ]);

                    Log::info('Roles insertados en la tabla roles en la base de datos: ' . $currentDatabase);
                } else {
                    Log::info('La tabla roles ya tiene datos en la base de datos: ' . $currentDatabase);
                }
            } else {
                Log::warning('La tabla roles no existe en la base de datos: ' . $currentDatabase);
            }
        } else {
            Log::error('No se pudo conectar a una base de datos válida.');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Forzar la conexión a la base de datos del colegio
        DB::purge('school');
        DB::reconnect('school');

        // Obtener el nombre de la base de datos actual para los logs
        $currentDatabase = DB::connection('school')->getDatabaseName();

        // Verificar si estamos conectados a una base de datos válida
        if ($currentDatabase) {
            Log::info('Conectado a la base de datos: ' . $currentDatabase);

            // Eliminar los roles si es necesario
            if (Schema::connection('school')->hasTable('roles')) {
                DB::connection('school')->table('roles')->whereIn('name', ['Administrador', 'Docente', 'Secretario', 'Estudiante'])->delete();
                Log::info('Roles eliminados de la tabla roles en la base de datos: ' . $currentDatabase);
            }
        } else {
            Log::error('No se pudo conectar a una base de datos válida.');
        }
    }
}

