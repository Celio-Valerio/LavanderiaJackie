<?php

namespace Database\Factories;

use App\Models\Puesto; // Asegúrate de importar el modelo Puesto
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empleado>
 */
class EmpleadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,  // Nombres
            'last_name' => $this->faker->lastName,  // Apellidos
            'email' => $this->faker->unique()->userName . '@gmail.com',  // Correo electrónico con dominio fijo
            'phone' => $this->faker->numberBetween(2, 9) . $this->faker->numerify('#######'),  // Teléfonos que empiezan con 2,3,8,9
            'address' => $this->faker->address,  // Dirección que parece real
            'hire_date' => $this->faker->date(),  // Fecha de ingreso
            'salary' => $this->faker->randomFloat(2, 1500, 5000),  // Salario entre 1500 y 5000
            'puesto_id' =>  $this->faker->numberBetween(2, 9), 
            'identity' => $this->faker->numerify('#############'),  // Referencia a un puesto aleatorio
            'emergency_number' => $this->faker->numberBetween(2, 9) . $this->faker->numerify('#######'),  // Teléfono de emergencia
            'emergency_contact_name' => $this->faker->name,  // Nombre de contacto de emergencia
        ];

        
            // Arreglo de puestos de trabajo reales en una granja
            $puestos = [
                
                'Operador de maquinaria',
                'Cajero',
                'Aseador',
                'Trabajador de mantenimiento',
            ];
    }
}
