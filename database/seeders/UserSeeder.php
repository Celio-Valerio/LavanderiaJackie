<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asumiendo que ya tienes un empleado creado, por ejemplo con ID 1
        DB::table('users')->insert([
            'name' => 'Jackie Moncada',
            'email' => 'jacky.moncada25@gmail.com',
            'password' => Hash::make('admin'),
            'direccion' => 'Bo. Tierra Blanca, media cuadra antes de Pintogama, Danlí, El Paraíso.', // Puedes cambiar esto si quieres
            'telefono' => '96085567', // Cambia este número si ya existe
            'image' => 'perfil2.png', // Imagen por defecto
            'empleado_id' => 1, // Asegúrate de que este ID exista en la tabla empleados
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'direccion' => 'Bo. Tierra Blanca, media cuadra antes de Pintogama, Danlí, El Paraíso.', // Puedes cambiar esto si quieres
            'telefono' => '96085568', // Cambia este número si ya existe
            'image' => 'perfil1.png', // Imagen por defecto
            'empleado_id' => 2, // Asegúrate de que este ID exista en la tabla empleados
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
