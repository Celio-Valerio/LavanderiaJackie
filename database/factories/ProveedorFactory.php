<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedor>
 */
class ProveedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name,  // Nombre completo del proveedor
            'email' => $this->faker->unique()->safeEmail,  // Correo electrónico
            'phone' => $this->faker->numberBetween(2, 9) . $this->faker->numerify('#######'),  // Teléfonos que empiezan con 2,3,8,9
            'company_name' => $this->faker->company . ' ' . $this->faker->randomElement(['SA', 'S de RL']),  // Nombre de la empresa con SA o S de RL
            'company_phone' => $this->faker->numberBetween(2, 9) . $this->faker->numerify('#######'),  // Teléfono de la empresa
            'company_address' => $this->faker->address,  // Dirección de la empresa
            'city' => $this->faker->randomElement(['Danlí', 'Comayagua', 'San Pedro Sula', 'La Esperanza', 'Tegucigalpa']), // Seleccionar ciudad aleatoria
            'categoria_id' => $this->faker->numberBetween(1, 8), // Referencia a un puesto aleatorio
        ];
    }
}
