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
        $permissionCatalog = [
            'services', 'customers', 'sales', 'reportes', 'users', 'inventories', 'dashboard'
        ];

        $servicesPermission = [
            [
                'name' => 'view services',
                'label' => 'Servicios ver',
            ],[
                'name' => 'create services',
                'label' => 'Servicios crear',
            ],[
                'name' => 'edit services',
                'label' => 'Servicios editar',
            ],[
                'name' => 'delete services',
                'label' => 'Servicios eliminar',
            ],
        ];

        $customersPermission = [
            [
                'name' => 'view customers',
                'label' => 'Clientes ver',
            ],[
                'name' => 'create customers',
                'label' => 'Clientes crear',
            ],[
                'name' => 'edit customers',
                'label' => 'Clientes editar',
            ],[
                'name' => 'delete customers',
                'label' => 'Clientes eliminar',
            ],
        ];

        $salesPermission = [
            [
                'name' => 'view sales',
                'label' => 'Ventas ver',
            ],[
                'name' => 'create sales',
                'label' => 'Ventas crear',
            ],[
                'name' => 'edit sales',
                'label' => 'Ventas editar',
            ],[
                'name' => 'delete sales',
                'label' => 'Ventas eliminar',
            ],
        ];

        $reportsPermission = [
            [
                'name' => 'view reports',
                'label' => 'Reportes ver',
            ]
        ];

        $usersPermission = [
            [
                'name' => 'view users',
                'label' => 'Usuarios ver',
            ],[
                'name' => 'create users',
                'label' => 'Usuarios crear',
            ],[
                'name' => 'edit users',
                'label' => 'Usuarios editar',
            ],[
                'name' => 'delete users',
                'label' => 'Usuarios eliminar',
            ],
        ];

        $rolesPermission = [
            [
                'name' => 'view roles',
                'label' => 'Roles ver',
            ],[
                'name' => 'create roles',
                'label' => 'Roles crear',
            ],[
                'name' => 'edit roles',
                'label' => 'Roles editar',
            ],[
                'name' => 'delete roles',
                'label' => 'Roles eliminar',
            ],
        ];

        $inventoriesPermission = [
            [
                'name' => 'view inventory',
                'label' => 'Inventario ver',
            ],[
                'name' => 'create inventory',
                'label' => 'Inventario crear',
            ],[
                'name' => 'edit inventory',
                'label' => 'Inventario editar',
            ],[
                'name' => 'delete inventory',
                'label' => 'Inventario eliminar',
            ],
        ];

        $permissions = [
            ...$servicesPermission,
            ...$customersPermission,
            ...$salesPermission,
            ...$reportsPermission,
            ...$usersPermission,
            ...$inventoriesPermission,
            ...$rolesPermission,
            [
                'name' => 'view dashboard',
                'label' => 'Ver Inicio',
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'guard_name' => 'sanctum',
                ...$permission
            ]);
        }

        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'sanctum',
        ]);
        $admin->givePermissionTo(
            collect($permissions)->pluck('name')->toArray()
        );
    }
}
