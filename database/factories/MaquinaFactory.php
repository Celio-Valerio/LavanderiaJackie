<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maquina>
 */
class MaquinaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'marca' => fake()->name(),
            'modelo' => fake()->name(),
            'capacidad' => fake()->numberBetween(1, 100),
            'estado' => fake()->name(),
            'proveedor' => fake()->name(),
            'fecha_adquisicion' => fake()->date(),
            'serie' => fake()->unique()->numerify('#########'),
        ];
    }
}
