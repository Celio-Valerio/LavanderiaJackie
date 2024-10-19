<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Maquinaria;

class MaquinariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Datos de ejemplo para la tabla maquinarias
        $maquinarias = [
            [
                'name' => 'Lavadora Industrial',
                'type' => 'Lavadora',
                'status' => 'operational',
                'acquisition_date' => '2022-03-15',
                'brand' => 'LG',
                'model' => 'T1234',
            ],
            [
                'name' => 'Secadora de Prendas',
                'type' => 'Secadora',
                'status' => 'operational',
                'acquisition_date' => '2021-06-20',
                'brand' => 'Whirlpool',
                'model' => 'S5678',
            ],
            [
                'name' => 'Planchadora de Vapor',
                'type' => 'Planchadora',
                'status' => 'under_maintenance',
                'acquisition_date' => '2023-01-10',
                'brand' => 'Bosch',
                'model' => 'P9101',
            ],
            [
                'name' => 'Extrusora de Detergente',
                'type' => 'Extrusora',
                'status' => 'operational',
                'acquisition_date' => '2020-12-05',
                'brand' => 'Procter & Gamble',
                'model' => 'E2345',
            ],
            [
                'name' => 'Lavadora de Carga Frontal',
                'type' => 'Lavadora',
                'status' => 'decommissioned',
                'acquisition_date' => '2019-07-30',
                'brand' => 'Samsung',
                'model' => 'LF1234',
            ],
            [
                'name' => 'Secadora a Gas',
                'type' => 'Secadora',
                'status' => 'operational',
                'acquisition_date' => '2021-09-12',
                'brand' => 'Maytag',
                'model' => 'SG5678',
            ],
            [
                'name' => 'Planchadora de Ropa',
                'type' => 'Planchadora',
                'status' => 'operational',
                'acquisition_date' => '2022-05-01',
                'brand' => 'Rowenta',
                'model' => 'PR9102',
            ],
            [
                'name' => 'Lavadora de Alta Eficiencia',
                'type' => 'Lavadora',
                'status' => 'operational',
                'acquisition_date' => '2023-03-18',
                'brand' => 'Electrolux',
                'model' => 'HE2345',
            ],
        ];

        // Insertar los datos en la tabla maquinarias
        foreach ($maquinarias as $maquinaria) {
            Maquinaria::create($maquinaria);
        }
    }
}
