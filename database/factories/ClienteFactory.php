<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Dominios de correo electrónicos comunes
        $emailDomains = ['gmail.com', 'yopmail.com', 'hotmail.com', 'yahoo.com', 'yahoo.es', 'outlook.com', 'unah.hn', 'unah.edu.hn'];

        return [
            'first_name' => $this->faker->firstName,  // Nombres
            'last_name' => $this->faker->lastName,  // Apellidos
            // Aproximadamente la mitad de los registros tendrán un correo, el resto será null
            'email' => $this->faker->boolean(50) ? $this->faker->unique()->userName . '@' . $this->faker->randomElement($emailDomains) : null,
            // Teléfonos que empiezan con 2,3,8,9
            'phone' => $this->faker->numberBetween(2, 9) . $this->faker->numerify('#######'),
            // Dirección que parece real
            'address' => $this->faker->address,
            // Alternar entre 'Contado' y 'Credito' aleatoriamente
            'type' => $this->faker->randomElement(['Contado', 'Credito']),
        ];
    }
}
