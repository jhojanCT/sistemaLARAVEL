<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Define permisos
        $permissions = [
            'gestionar usuarios',
            'gestionar roles',
            'gestionar cuentas',
            'gestionar materias primas',
            'gestionar productos',
            'gestionar categorías',
            'gestionar proveedores',
            'gestionar clientes',
            'gestionar filtros',
            'gestionar almacén filtrado',
            'gestionar almacén sin filtro',
            'gestionar entradas de producción',
            'gestionar salidas de producción',
            'gestionar ventas de productos',
            'gestionar ventas de materia prima',
        ];

        // Crea permisos
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crea el rol Superadmin
        $superAdmin = Role::firstOrCreate(['name' => 'superadmin']);

        // Asocia todos los permisos al rol Superadmin
        $superAdmin->syncPermissions($permissions);

        // Crear el usuario Superadmin
        $superadminUser = User::updateOrCreate(
            ['email' => 'superadmin@example.com'], // Cambia este email si lo necesitas
            [
                'name' => 'Superadmin',
                'password' => bcrypt('12345678'), // Cambia esta contraseña según lo necesites
            ]
        );


        // Asigna el rol Superadmin al usuario
        $superadminUser->assignRole($superAdmin);

        // Mensaje informativo en consola
        $this->command->info('Superadmin creado con email: superadmin@example.com y contraseña: 12345678');
    
        //php artisan db:seed --class=PermissionsSeeder


    }
}
