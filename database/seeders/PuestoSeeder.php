<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Puesto; // Asegúrate de importar el modelo Puesto

class PuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array con datos de puestos
        $puestos = [
            ['name' => 'Propietario de la Lavandería', 'description' => 'Responsable de la gestión general de la lavandería.'],
            ['name' => 'Ayudante de Lavandería', 'description' => 'Asiste en el lavado, secado y manejo de la ropa.'],
            ['name' => 'Especialista en Lavado en Seco', 'description' => 'Encargado del tratamiento especializado de prendas delicadas.'],
            ['name' => 'Operador de Máquinas de Lavado', 'description' => 'Supervisa y opera las máquinas de lavado y secado.'],
            ['name' => 'Contador de Lavandería', 'description' => 'Maneja las finanzas y registros de la lavandería.'],
            ['name' => 'Recepcionista de Lavandería', 'description' => 'Atiende a clientes y gestiona pedidos.'],
            ['name' => 'Vendedor de Servicios de Lavandería', 'description' => 'Encargado de la promoción y venta de servicios de la lavandería.'],
            ['name' => 'Promotor de Servicios Ecológicos', 'description' => 'Desarrolla campañas para promover servicios de lavado ecológico.'],
            ['name' => 'Técnico en Mantenimiento de Máquinas', 'description' => 'Repara y mantiene las máquinas de la lavandería.'],
            ['name' => 'Encargado de Recursos Humanos', 'description' => 'Gestiona el personal y sus tareas en la lavandería.'],
        ];


        // Insertar los puestos en la base de datos
        foreach ($puestos as $puesto) {
            Puesto::create($puesto);
        }
    }
}
