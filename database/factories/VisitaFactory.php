<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;

class VisitaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::inRandomOrder()->first()->id ?? Cliente::factory(), // Cliente aleatorio o creado en el factory
            'fecha_visita' => $this->faker->dateTimeBetween('-1 year', 'now'), // Fecha aleatoria en el último año
        ];
    }
}
