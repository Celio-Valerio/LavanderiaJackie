<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Puesto;

class PuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array con datos de puestos
        $puestos = [
            ['name' => 'Propietario de la lavandería', 'description' => 'Responsable de la gestión general de la lavandería.'],
            ['name' => 'Ayudante de lavandería', 'description' => 'Asiste en el lavado, secado y manejo de la ropa.'],
            ['name' => 'Especialista en lavado en seco', 'description' => 'Encargado del tratamiento especializado de prendas delicadas.'],
            ['name' => 'Operador de máquinas de lavado', 'description' => 'Supervisa y opera las máquinas de lavado y secado.'],
            ['name' => 'Contador de lavandería', 'description' => 'Maneja las finanzas y registros de la lavandería.'],
            ['name' => 'Recepcionista de lavandería', 'description' => 'Atiende a clientes y gestiona pedidos.'],
            ['name' => 'Vendedor de servicios de lavandería', 'description' => 'Encargado de la promoción y venta de servicios de la lavandería.'],
            ['name' => 'Promotor de servicios ecológicos', 'description' => 'Desarrolla campañas para promover servicios de lavado ecológico.'],
            ['name' => 'Técnico en mantenimiento de máquinas', 'description' => 'Repara y mantiene las máquinas de la lavandería.'],
            ['name' => 'Encargado de recursos humanos', 'description' => 'Gestiona el personal y sus tareas en la lavandería.'],
        ];

        // Insertar los puestos en la base de datos
        foreach ($puestos as $puesto) {
            Puesto::create($puesto);
        }
    }
}
