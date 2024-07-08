<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'edit articles',
            'delete articles',
            'publish articles',
            'unpublish articles'
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Crear roles y asignar permisos
        $role = Role::create(['name' => 'normal']);
        $role->givePermissionTo('');
        
        $role = Role::create(['name' => 'administrador']);
        $role->givePermissionTo(['edit articles', 'delete articles', 'publish articles', 'unpublish articles']);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);
        // Asignación del rol
        $user->assignRole('administrador');
    }
}