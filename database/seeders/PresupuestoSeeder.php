<?php

namespace Database\Seeders;

use App\Models\Presupuesto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $presupuesto = new Presupuesto();
        $presupuesto->descripcion = 'Presupuesto Global';
        $presupuesto->cantidad = 100000;
        $presupuesto->fecha = '20250120';
        $presupuesto->gastado = 90000;
        $presupuesto->save();
    }
}
