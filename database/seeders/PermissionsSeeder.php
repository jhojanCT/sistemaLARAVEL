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


      
        // Asocia todos los permisos al rol Superadmin
        $superAdmin->syncPermissions($permissions);

        // Crear el usuario Superadmin
        $superadminUser = User::updateOrCreate(
            ['email' => 'superadmin@example.com'], // Cambia este email si lo necesitas
            [
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
