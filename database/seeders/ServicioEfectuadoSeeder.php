<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServicioEfectuado;

class ServicioEfectuadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Crear 10 servicios efectuados
        \App\Models\ServicioEfectuado::factory()->count(5)->create();
    }
}
