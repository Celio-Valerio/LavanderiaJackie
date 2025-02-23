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
            'numero_factura' => strtoupper($this->faker->bothify('C2#112024######000##')), // Genera un número de factura único
            'fecha_compra' => $this->faker->dateTimeBetween('2000-01-01', 'now')->format('Y-m-d'), // Genera una fecha entre el 01/01/2000 y la fecha actual
            'descripcion' => $this->faker->sentence, // Descripción opcional de la compra
            'presupuesto_id' => 1,
        ];
    }

    /**
     * Establecer el proveedor para la compra.
     *
     * @param
     * @return $this
     */

}
