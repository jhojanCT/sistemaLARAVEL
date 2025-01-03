<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
{
    // Crear permisos
    $permissions = [
        'ver clientes',
        'gestionar productos',
        'gestionar categorías',
        'gestionar proveedores',
        'gestionar entradas',
        'gestionar salidas',
        'gestionar roles',
        'gestionar usuarios',
        'ver reportes',
    ];

    foreach ($permissions as $permission) {
        Permission::create(['name' => $permission]);
    }

    // Crear roles y asignar permisos
    $superadmin = Role::create(['name' => 'Superadministrador']);
    $superadmin->givePermissionTo(Permission::all());

    Role::create(['name' => 'Gerente']);
    Role::create(['name' => 'Vendedor']);
    Role::create(['name' => 'Controlador']);
}
}
