<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array con datos de categorías
        $categorias = [
            [
                'name' => 'Maquinaria', 'description' => 'Equipos y máquinas utilizados en el proceso de lavado y secado.'
            ],

            [
                'name' => 'Productos',
                'description' => 'Materiales como detergentes, suavizantes, y otros productos químicos utilizados en el proceso de lavado.'
            ],
            [
                'name' => 'Servicios',
                'description' => 'Servicios de lavandería como lavado, secado, planchado y entrega a domicilio.'
            ]

        ];

        // Insertar las categorías en la base de datos
        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }

    }
}
