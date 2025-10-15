<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view sales',
            'create sales',
            'view reports',
            'manage users',
            'manage inventory',
            'view dashboard'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo($permissions);

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'view sales',
            'create sales',
            'view reports',
            'manage inventory',
            'view dashboard'
        ]);

        $cashier = Role::create(['name' => 'cashier']);
        $cashier->givePermissionTo([
            'view products',
            'view sales',
            'create sales',
            'view dashboard'
        ]);

        $viewer = Role::create(['name' => 'viewer']);
        $viewer->givePermissionTo([
            'view products',
            'view sales',
            'view dashboard'
        ]);
    }
}
