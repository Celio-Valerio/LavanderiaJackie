<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maquinaria>
 */
class MaquinariaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word() . ' ' . $this->faker->word(), // Nombre de la maquinaria, como "Lavadora Industrial"
            'type' => $this->faker->randomElement(['Lavadora', 'Secadora', 'Planchadora', 'Extrusora']), // Tipo de maquinaria
            'status' => $this->faker->randomElement(['operational', 'under_maintenance', 'decommissioned','New','Used']), // Estado
            'acquisition_date' => $this->faker->date(), // Fecha de adquisición
            'brand' => $this->faker->company, // Marca de la maquinaria
            'model' => $this->faker->bothify('Model ###'), // Modelo de la maquinaria, como "Model 123"
        ];
    }
}
