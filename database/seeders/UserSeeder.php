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
            'name'               => 'Jackie Moncada',
            'email'              => 'jacky.moncada25@gmail.com',
            'password'           => Hash::make('admin'),
            'direccion'          => 'Bo. Tierra Blanca, media cuadra antes de Pintogama, Danlí, El Paraíso.',
            'telefono'           => '96085567',
            'image'              => 'perfil2.png',
            'empleado_id'        => 1,
            'security_question'  => '¿Cuál es el nombre de tu primera mascota?',
            'security_answer'    => Hash::make('Firulais'),
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        DB::table('users')->insert([
            'name'               => 'Super Admin',
            'email'              => 'admin@gmail.com',
            'password'           => Hash::make('admin'),
            'direccion'          => 'Bo. Tierra Blanca, media cuadra antes de Pintogama, Danlí, El Paraíso.',
            'telefono'           => '96085568',
            'image'              => 'perfil1.png',
            'empleado_id'        => 2,
            'security_question'  => '¿En qué ciudad naciste?',
            'security_answer'    => Hash::make('Danlí'),
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);
    }
}
