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
            'phone' => $this->faker->randomElement([2, 3, 8, 9]) . $this->faker->numerify('#######'),
            'address' => 'Calle ' . $this->faker->randomDigitNotNull() .
                ', casa ' . $this->faker->randomNumber(2) .
                ', Colonia ' . $this->faker->randomElement(['La Concepción', 'Nueva Esperanza', 'Cofradía']) .
                ', Danlí.',

            'hire_date' => $this->faker->date(),  // Fecha de ingreso
            'salary' => $this->faker->randomFloat(2, 1500, 5000),  // Salario entre 1500 y 5000
            'puesto_id' =>  $this->faker->numberBetween(2, 9), // Referencia a un puesto aleatorio
        ];
    }
}
