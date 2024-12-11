<?php

namespace Database\Seeders;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Proveedor;  // Asegúrate de incluir el modelo de Proveedor
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
            // Obtener un proveedor aleatorio
            $proveedor = Proveedor::inRandomOrder()->first();

            // Verificar si se obtuvo un proveedor válido
            if (!$proveedor) {
                // Si no se encuentra ningún proveedor, continuar con la siguiente iteración
                continue;
            }

            // Crear una compra utilizando el proveedor obtenido
            $compra = Compra::factory()
                ->withProveedor($proveedor->id) // Usar el ID del proveedor
                ->create();

            // Generar entre 1 y 10 detalles de compra para cada compra
            $productos = Producto::inRandomOrder()->take(rand(1, 10))->get();

            foreach ($productos as $producto) {
                DetalleCompra::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $producto->id,
                    'cantidad' => rand(1, 20), // Cantidad entre 1 y 20
                    'precio' => $producto->precio, // Precio tomado del producto
                    'descuento' => 0, // Descuento (puedes cambiar esto si necesitas más lógica)
                ]);
            }
        }
    }
}
