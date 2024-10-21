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
        $maquinarias = [
            [
                'name' => 'Lavadora Industrial',
                'type' => 'Lavadora',
                'status' => 'En reparación',
                'acquisition_date' => '2022-03-15',
                'brand' => 'LG',
                'model' => 'T1234',
            ],
            [
                'name' => 'Secadora de Prendas',
                'type' => 'Secadora',
                'status' => 'Operativa',
                'acquisition_date' => '2021-06-20',
                'brand' => 'Whirlpool',
                'model' => 'S5678',
            ],
            [
                'name' => 'Planchadora de Vapor',
                'type' => 'Planchadora',
                'status' => 'En mantenimiento',
                'acquisition_date' => '2023-01-10',
                'brand' => 'Bosch',
                'model' => 'P9101',
            ],
            [
                'name' => 'Extrusora de Detergente',
                'type' => 'Extrusora',
                'status' => 'Operativa',
                'acquisition_date' => '2020-12-05',
                'brand' => 'Procter & Gamble',
                'model' => 'E2345',
            ],
            [
                'name' => 'Lavadora de Carga Frontal',
                'type' => 'Lavadora',
                'status' => 'Dada de baja',
                'acquisition_date' => '2019-07-30',
                'brand' => 'Samsung',
                'model' => 'LF1234',
            ],
            [
                'name' => 'Secadora a Gas',
                'type' => 'Secadora',
                'status' => 'Operativa',
                'acquisition_date' => '2021-09-12',
                'brand' => 'Maytag',
                'model' => 'SG5678',
            ],
            [
                'name' => 'Planchadora de Ropa',
                'type' => 'Planchadora',
                'status' => 'Operativa',
                'acquisition_date' => '2022-05-01',
                'brand' => 'Rowenta',
                'model' => 'PR9102',
            ],
            [
                'name' => 'Lavadora de Alta Eficiencia',
                'type' => 'Lavadora',
                'status' => 'Operativa',
                'acquisition_date' => '2023-03-18',
                'brand' => 'Electrolux',
                'model' => 'HE2345',
            ],
            [
                'name' => 'Centrifugadora',
                'type' => 'Centrifugadora',
                'status' => 'Operativa',
                'acquisition_date' => '2023-04-10',
                'brand' => 'Fagor',
                'model' => 'C9001',
            ],
            [
                'name' => 'Prensa de Ropa',
                'type' => 'Prensa',
                'status' => 'En mantenimiento',
                'acquisition_date' => '2022-11-05',
                'brand' => 'Teka',
                'model' => 'PR8901',
            ],
            [
                'name' => 'Desmanchadora',
                'type' => 'Desmanchadora',
                'status' => 'Operativa',
                'acquisition_date' => '2021-12-15',
                'brand' => 'Kärcher',
                'model' => 'D1000',
            ],
            [
                'name' => 'Máquina de Planchado',
                'type' => 'Planchadora',
                'status' => 'Dada de baja',
                'acquisition_date' => '2018-05-20',
                'brand' => 'Philips',
                'model' => 'P9500',
            ],
            [
                'name' => 'Máquina de Rociado',
                'type' => 'Rociadora',
                'status' => 'Operativa',
                'acquisition_date' => '2022-07-25',
                'brand' => 'Graco',
                'model' => 'G5000',
            ],
            [
                'name' => 'Cámara de Secado',
                'type' => 'Secado',
                'status' => 'En mantenimiento',
                'acquisition_date' => '2023-02-18',
                'brand' => 'Nordic',
                'model' => 'CS600',
            ],
            [
                'name' => 'Máquina de Embalaje',
                'type' => 'Embalaje',
                'status' => 'Operativa',
                'acquisition_date' => '2021-08-30',
                'brand' => 'PackTech',
                'model' => 'PE1500',
            ],
            [
                'name' => 'Máquina de Doblado',
                'type' => 'Dobladora',
                'status' => 'Operativa',
                'acquisition_date' => '2023-05-05',
                'brand' => 'Böhler',
                'model' => 'D750',
            ],
            [
                'name' => 'Calandra',
                'type' => 'Calandra',
                'status' => 'Dada de baja',
                'acquisition_date' => '2017-09-15',
                'brand' => 'Draper',
                'model' => 'C900',
            ],
            [
                'name' => 'Máquina de Hidrolavado',
                'type' => 'Hidrolavadora',
                'status' => 'Operativa',
                'acquisition_date' => '2023-03-22',
                'brand' => 'Kärcher',
                'model' => 'HD150',
            ],
            [
                'name' => 'Máquina de Acabado',
                'type' => 'Acabado',
                'status' => 'Pendiente de revisión',
                'acquisition_date' => '2022-10-05',
                'brand' => 'Rema',
                'model' => 'AC320',
            ],
        ];

        foreach ($maquinarias as $maquinaria) {
            Maquinaria::create($maquinaria);
        }

    }

}
