<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeederForSchool extends Seeder
{
    public function run()
    {
        // Crear los roles específicos para el colegio
        $roles = [
            'Administrador',
            'Docente',
            'Secretario',
            'Estudiante',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // Crear permisos básicos para el colegio
        $permissions = [
            'gestionar-cursos',
            'ver-boletines',
            'registrar-calificaciones',
            'ver-pagos',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Asignar permisos al rol de Administrador
        $adminRole = Role::where('name', 'Administrador')->first();
        $adminRole->givePermissionTo($permissions);
    }
}
