<?php

namespace Database\Seeders;

use App\Models\Mantenimiento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MantenimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Datos de ejemplo para la tabla mantenimientos
        $mantenimientos = [
            [
                'date' => '2023-04-15',
                'maquinaria_id' => 1, // ID de la Lavadora Industrial
                'maintenance_type' => 'Preventivo',
                'description' => 'Revisión general de la lavadora para asegurar su correcto funcionamiento.',
                'price' => 150.00,
            ],
            [
                'date' => '2023-05-10',
                'maquinaria_id' => 2, // ID de la Secadora de Prendas
                'maintenance_type' => 'Correctivo',
                'description' => 'Reemplazo del termostato debido a fallas en el calentamiento.',
                'price' => 200.00,
            ],
            [
                'date' => '2023-06-22',
                'maquinaria_id' => 3, // ID de la Planchadora de Vapor
                'maintenance_type' => 'Emergencia',
                'description' => 'Fuga de vapor, reparación urgente requerida.',
                'price' => 120.00,
            ],
            [
                'date' => '2023-07-30',
                'maquinaria_id' => 4, // ID de la Extrusora de Detergente
                'maintenance_type' => 'Emergencia',
                'description' => 'Inspección de rutina para detectar desgastes.',
                'price' => 90.00,
            ],
            [
                'date' => '2023-08-05',
                'maquinaria_id' => 5, // ID de la Lavadora de Carga Frontal
                'maintenance_type' => 'Correctivo',
                'description' => 'Reparación de fuga de agua.',
                'price' => 250.00,
            ],
            [
                'date' => '2023-09-12',
                'maquinaria_id' => 6, // ID de la Secadora a Gas
                'maintenance_type' => 'Preventivo',
                'description' => 'Limpieza y ajuste del sistema de gas.',
                'price' => 100.00,
            ],
            [
                'date' => '2023-09-30',
                'maquinaria_id' => 7, // ID de la Planchadora de Ropa
                'maintenance_type' => 'Emergencia',
                'description' => 'Reparación por mal funcionamiento durante la operación.',
                'price' => 80.00,
            ],
            [
                'date' => '2023-10-15',
                'maquinaria_id' => 8, // ID de la Lavadora de Alta Eficiencia
                'maintenance_type' => 'Preventivo',
                'description' => 'Verificación de funcionamiento y limpieza del tambor.',
                'price' => 60.00,
            ],
        ];

        // Insertar los datos en la tabla mantenimientos
        foreach ($mantenimientos as $mantenimiento) {
            Mantenimiento::create($mantenimiento);
        }
    }
}
