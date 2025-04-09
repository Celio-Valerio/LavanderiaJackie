<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('empleados')->insert([
            'identity_number' => '0703198504884', // Ejemplo de número de identidad válido en Honduras
            'first_name' => 'Jackie',
            'last_name' => 'Moncada',
            'email' => 'jacky.moncada25@gmail.com',
            'phone' => '96085567', // Asegúrate de que no esté duplicado
            'address' => 'Colonia Los Robles, Tegucigalpa',
            'puesto_id' => 1, // Asegúrate de que el puesto con ID 1 exista
            'hire_date' => now()->subYears(2)->toDateString(), // Fecha de ingreso simulada
            'fecha_salida' => null, // Aún activo
            'salary' => 25000.00,
            'estado' => 'Activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('empleados')->insert([
            'identity_number' => '0801199901234', // Ejemplo de número de identidad válido en Honduras
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '99009900', // Asegúrate de que no esté duplicado
            'address' => 'Colonia Los Robles, Tegucigalpa',
            'puesto_id' => 1, // Asegúrate de que el puesto con ID 1 exista
            'hire_date' => now()->subYears(2)->toDateString(), // Fecha de ingreso simulada
            'fecha_salida' => null, // Aún activo
            'salary' => 25000.00,
            'estado' => 'Activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
