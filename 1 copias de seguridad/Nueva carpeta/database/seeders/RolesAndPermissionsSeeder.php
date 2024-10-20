<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Verificar si el rol ya existe antes de crearlo
        $superAdminRole = Role::firstOrCreate(['name' => 'SuperAdministrador']);
        $adminRole = Role::firstOrCreate(['name' => 'AdministradorColegio']);
        $docenteRole = Role::firstOrCreate(['name' => 'Docente']);
        $estudianteRole = Role::firstOrCreate(['name' => 'Estudiante']);
        $secretarioRole = Role::firstOrCreate(['name' => 'Secretario']);
        $coordinadorRole = Role::firstOrCreate(['name' => 'CoordinadorAcademico']);
        $contadorRole = Role::firstOrCreate(['name' => 'Contador']);
        
        // Verificar si los permisos ya existen antes de crearlos
        $gestionarCursosPermission = Permission::firstOrCreate(['name' => 'gestionar-cursos']);
        $verBoletinesPermission = Permission::firstOrCreate(['name' => 'ver-boletines']);
        $registrarCalificacionesPermission = Permission::firstOrCreate(['name' => 'registrar-calificaciones']);
        $verPagosPermission = Permission::firstOrCreate(['name' => 'ver-pagos']);
        
        // Asignar permisos a roles
        $superAdminRole->givePermissionTo([$gestionarCursosPermission, $verBoletinesPermission, $registrarCalificacionesPermission, $verPagosPermission]);

        // Asignar roles y permisos a un usuario de prueba
        $user = User::find(1); // Encuentra al usuario con ID 1
        if ($user) {
            $user->assignRole($superAdminRole); // Asigna el rol de SuperAdministrador
        }
    }
}

