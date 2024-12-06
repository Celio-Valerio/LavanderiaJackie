<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gasto>
 */
class GastoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha' => $this->faker->dateTimeBetween('2000-01-01', 'now')->format('Y-m-d'), // Genera una fecha entre el 01/01/2000 y la fecha actual
            'descripcion' => $this->faker->sentence, // Descripción opcional de la compra   
            'monto' => $this->faker->randomFloat(2, 1, 1000), // Monto aleatorio entre 1 y 1000 con 2 decimales
            'totalAmount' => $this->faker->randomFloat(2, 1, 1000), // Monto aleatorio entre 1 y 1000 con 2 decimales
        ];
    }
}
