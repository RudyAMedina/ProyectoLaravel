<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Crear roles si no existen
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleUser = Role::firstOrCreate(['name' => 'user']);
        $roleNormal = Role::firstOrCreate(['name' => 'normal']);

        // Crear permisos si no existen
        $permissionCreate = Permission::firstOrCreate(['name' => 'create']);
        $permissionEdit = Permission::firstOrCreate(['name' => 'edit']);
        $permissionDelete = Permission::firstOrCreate(['name' => 'delete']);

        // Asignar permisos a roles
        $roleAdmin->givePermissionTo([$permissionCreate, $permissionEdit, $permissionDelete]);
        $roleUser->givePermissionTo($permissionEdit);
        $roleNormal->givePermissionTo($permissionEdit);

        // Crear usuario admin si no existe
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'), // Reemplaza 'password' con una contraseña segura
            ]
        );

        // Asignar rol admin al usuario
        $user->assignRole($roleAdmin);
    }
}
