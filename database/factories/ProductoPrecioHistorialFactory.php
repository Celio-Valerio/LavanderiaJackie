<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\ProductoPrecioHistorial;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoPrecioHistorialFactory extends Factory
{
    protected $model = ProductoPrecioHistorial::class;

    public function definition()
    {
        // Generar el precio anterior aleatorio
        $precioAnterior = $this->faker->randomFloat(2, 10, 100);

        // El precio nuevo será igual o mayor que el precio anterior
        $precioNuevo = $this->faker->randomFloat(2, $precioAnterior, 100);

        return [
            'producto_id' => Producto::inRandomOrder()->first()->id, // Producto aleatorio
            'precio_anterior' => $precioAnterior, // Precio anterior aleatorio
            'precio_nuevo' => $precioNuevo, // Precio nuevo aleatorio, no negativo
            'fecha_cambio' => $this->faker->dateTimeThisYear(), // Fecha de cambio aleatoria
        ];
    }
}
