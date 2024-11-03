<?php

namespace Database\Factories;

use App\Models\Compra;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraFactory extends Factory
{
    protected $model = Compra::class;

    /**
     * Define el estado predeterminado del modelo.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'numero_factura' => strtoupper($this->faker->bothify('FAC-#####')), // Genera un número de factura único
            'fecha_compra' => $this->faker->date(), // Genera una fecha de compra
            'descripcion' => $this->faker->sentence, // Descripción opcional de la compra
            'proveedor_id' => $this->faker->numberBetween(1, 10), // ID de un proveedor aleatorio (puedes ajustar esto)
        ];
    }

    /**
     * Establecer el proveedor para la compra.
     *
     * @param int $proveedorId
     * @return $this
     */
    public function withProveedor(int $proveedorId)
    {
        return $this->state(function (array $attributes) use ($proveedorId) {
            return [
                'proveedor_id' => $proveedorId,
            ];
        });
    }
}
