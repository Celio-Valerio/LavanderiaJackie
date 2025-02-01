<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\Promo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServicioEfectuado>
 */
class ServicioEfectuadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtener un cliente y un servicio aleatorio
        $cliente = Cliente::inRandomOrder()->first();
        $servicio = Servicio::inRandomOrder()->first();
        $promo = Promo::inRandomOrder()->first();

        return [
            'cliente_id' => $cliente ? $cliente->id : null, // Cliente aleatorio
            'servicio_id' => $servicio ? $servicio->id : null, // Servicio aleatorio
            'promo_id' => $promo ? $promo->id : null, // Promoción aleatoria o null si no aplica
            'libras' => $this->faker->numberBetween(1, 10), // Número aleatorio de libras (1-10)
            'notas' => $this->faker->text(200), // Notas aleatorias
            'estado' => $this->faker->randomElement(['Pendiente', 'Terminado', 'Entregado']), // Estado aleatorio
            'envio' => $this->faker->randomElement(['A domicilio', 'Local']), // Tipo de envío aleatorio
            'total' => function (array $attributes) {
                // Calcular el total basado en las libras y el precio del servicio
                $servicio = Servicio::find($attributes['servicio_id']);
                $precioPorLibra = $servicio ? $servicio->precio : 0;
                return $attributes['libras'] * $precioPorLibra; // Total calculado por libras
            },
            // Nuevas columnas
            'direccion' => $this->faker->address, // Dirección aleatoria
            'precio_envio' => $this->faker->randomFloat(2, 0, 50), // Precio de envío aleatorio entre 0 y 50
            'pago_envio' => $this->faker->randomElement(['Cliente', 'Empresa']), // Quien paga el envío aleatorio
            'fecha' => $this->faker->date(), // Fecha aleatoria
            'hora' => $this->faker->time('H:i'), // Hora aleatoria en formato 24 horas
        ];
    }
}
