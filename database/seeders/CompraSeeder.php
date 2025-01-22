<?php

namespace Database\Seeders;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class CompraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 10 compras simuladas
        for ($i = 0; $i < 10; $i++) {
            // Obtener un producto aleatorio para obtener el proveedor
            $producto = Producto::inRandomOrder()->first();

            // Crear una compra utilizando el proveedor del producto
            $compra = Compra::factory()
                // Usar el proveedor del producto
                ->create();

            // Generar entre 1 y 10 detalles de compra para cada compra
            $productos = Producto::inRandomOrder()->take(rand(1, 10))->get();

            foreach ($productos as $producto) {
                DetalleCompra::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $producto->id,
                    'cantidad' => rand(1, 20), // Cantidad entre 1 y 20
                    'precio' => $producto->precio, // Precio tomado del producto
                    'descuento' => 0, // Descuento entre 0% y 10%
                ]);
            }
        }
    }
}
