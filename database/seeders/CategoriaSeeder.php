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
            ['name' => 'Agua', 'description' => 'Productos y servicios relacionados con el suministro de agua para el lavado.'],
            ['name' => 'Maquinaria', 'description' => 'Equipos y máquinas utilizados en el proceso de lavado y secado.'],
            ['name' => 'Detergente', 'description' => 'Detergentes y otros productos de limpieza para el lavado de ropa.'],
            ['name' => 'Cloro', 'description' => 'Productos de blanqueo y desinfección utilizados en la lavandería.'],
            ['name' => 'Repuestos', 'description' => 'Partes y piezas para el mantenimiento de las máquinas de lavandería.'],
            ['name' => 'Jabón', 'description' => 'Jabones y productos relacionados para el cuidado de prendas delicadas.'],
            ['name' => 'Suavizante', 'description' => 'Productos que suavizan y protegen la ropa durante el lavado.'],
            ['name' => 'Productos Ecológicos', 'description' => 'Productos biodegradables y ecológicos para un lavado responsable.']
        ];

        // Insertar las categorías en la base de datos
        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }

    }
}
