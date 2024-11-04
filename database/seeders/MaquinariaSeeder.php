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
                'name' => 'Lavadora industrial',
                'type' => 'Lavadora',
                'status' => 'En reparación',
                'acquisition_date' => '2022-03-15',
                'brand' => 'LG',
                'model' => 'T1234',
                'proveedor_id' => '1',
            ],
            [
                'name' => 'Secadora de prendas',
                'type' => 'Secadora',
                'status' => 'Operativa',
                'acquisition_date' => '2021-06-20',
                'brand' => 'Whirlpool',
                'model' => 'S5678',
                'proveedor_id' => '2',
            ],
            [
                'name' => 'Planchadora de vapor',
                'type' => 'Planchadora',
                'status' => 'En mantenimiento',
                'acquisition_date' => '2023-01-10',
                'brand' => 'Bosch',
                'model' => 'P9101',
                'proveedor_id' => '3',
            ],
            [
                'name' => 'Extrusora de detergente',
                'type' => 'Extrusora',
                'status' => 'Operativa',
                'acquisition_date' => '2020-12-05',
                'brand' => 'Procter & Gamble',
                'model' => 'E2345',
                'proveedor_id' => '4',
            ],
            [
                'name' => 'Lavadora de carga Frontal',
                'type' => 'Lavadora',
                'status' => 'Dada de baja',
                'acquisition_date' => '2019-07-30',
                'brand' => 'Samsung',
                'model' => 'LF1234',
                'proveedor_id' => '5',
            ],
            [
                'name' => 'Secadora a gas',
                'type' => 'Secadora',
                'status' => 'Operativa',
                'acquisition_date' => '2021-09-12',
                'brand' => 'Maytag',
                'model' => 'SG5678',
                'proveedor_id' => '6',
            ],
            [
                'name' => 'Planchadora de ropa',
                'type' => 'Planchadora',
                'status' => 'Operativa',
                'acquisition_date' => '2022-05-01',
                'brand' => 'Rowenta',
                'model' => 'PR9102',
                'proveedor_id' => '7',
            ],
            [
                'name' => 'Lavadora de alta eficiencia',
                'type' => 'Lavadora',
                'status' => 'Operativa',
                'acquisition_date' => '2023-03-18',
                'brand' => 'Electrolux',
                'model' => 'HE2345',
                'proveedor_id' => '8',
            ],
            [
                'name' => 'Centrifugadora',
                'type' => 'Centrifugadora',
                'status' => 'Operativa',
                'acquisition_date' => '2023-04-10',
                'brand' => 'Fagor',
                'model' => 'C9001',
                'proveedor_id' => '1',
            ],
            [
                'name' => 'Prensa de ropa',
                'type' => 'Prensa',
                'status' => 'En mantenimiento',
                'acquisition_date' => '2022-11-05',
                'brand' => 'Teka',
                'model' => 'PR8901',
                'proveedor_id' => '1',
            ],
            [
                'name' => 'Desmanchadora',
                'type' => 'Desmanchadora',
                'status' => 'Operativa',
                'acquisition_date' => '2021-12-15',
                'brand' => 'Kärcher',
                'model' => 'D1000',
                'proveedor_id' => '2',
            ],
            [
                'name' => 'Máquina de planchado',
                'type' => 'Planchadora',
                'status' => 'Dada de baja',
                'acquisition_date' => '2018-05-20',
                'brand' => 'Philips',
                'model' => 'P9500',
                'proveedor_id' => '1',
            ],
            [
                'name' => 'Máquina de rociado',
                'type' => 'Rociadora',
                'status' => 'Operativa',
                'acquisition_date' => '2022-07-25',
                'brand' => 'Graco',
                'model' => 'G5000',
                'proveedor_id' => '1',
            ],
            [
                'name' => 'Cámara de secado',
                'type' => 'Secado',
                'status' => 'En mantenimiento',
                'acquisition_date' => '2023-02-18',
                'brand' => 'Nordic',
                'model' => 'CS600',
                'proveedor_id' => '8',
            ],
            [
                'name' => 'Máquina de embalaje',
                'type' => 'Embalaje',
                'status' => 'Operativa',
                'acquisition_date' => '2021-08-30',
                'brand' => 'PackTech',
                'model' => 'PE1500',
                'proveedor_id' => '2',
            ],
            [
                'name' => 'Máquina de doblado',
                'type' => 'Dobladora',
                'status' => 'Operativa',
                'acquisition_date' => '2023-05-05',
                'brand' => 'Böhler',
                'model' => 'D750',
                'proveedor_id' => '2',
            ],
            [
                'name' => 'Calandra',
                'type' => 'Calandra',
                'status' => 'Dada de baja',
                'acquisition_date' => '2017-09-15',
                'brand' => 'Draper',
                'model' => 'C900',
                'proveedor_id' => '2',
            ],
            [
                'name' => 'Máquina de hidrolavado',
                'type' => 'Hidrolavadora',
                'status' => 'Operativa',
                'acquisition_date' => '2023-03-22',
                'brand' => 'Kärcher',
                'model' => 'HD150',
                'proveedor_id' => '3',
            ],
            [
                'name' => 'Máquina de acabado',
                'type' => 'Acabado',
                'status' => 'Pendiente de revisión',
                'acquisition_date' => '2022-10-05',
                'brand' => 'Rema',
                'model' => 'AC320',
                'proveedor_id' => '1',
            ],
        ];

        foreach ($maquinarias as $maquinaria) {
            Maquinaria::create($maquinaria);
        }

    }

}
