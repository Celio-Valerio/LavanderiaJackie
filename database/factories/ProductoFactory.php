<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    /**
     * Define el estado predeterminado del modelo.
     *
     * @return array
     */
    public function definition()
    {
        // Lista de nombres de productos comunes en lavanderías
        $nombres = [
            'Detergente líquido',
            'Suavizante de ropa',
            'Blanqueador',
            'Limpiador de manchas',
            'Bolsa para lavado',
            'Rociador de aroma',
            'Jabón para lavar a mano',
            'Cuidado de colores',
            'Desinfectante',
            'Limpiador multiusos',
        ];

        // Descripciones breves para los productos
        $descripciones = [
            'Detergente concentrado para una limpieza profunda.',
            'Suaviza la ropa y deja un agradable aroma.',
            'Ideal para blanquear ropa blanca y eliminar manchas difíciles.',
            'Elimina manchas difíciles de la ropa con facilidad.',
            'Bolsa resistente para el lavado de prendas delicadas.',
            'Aroma fresco y duradero para tus prendas.',
            'Jabón ideal para lavar a mano y cuidar tus prendas.',
            'Protege los colores de tu ropa y mantiene su brillo.',
            'Desinfecta y limpia superficies con un agradable olor.',
            'Limpiador multiusos perfecto para el hogar.',
        ];

        // Precios permitidos
        $precios = [10, 20, 100, 500, 1000];

        // Asignación de categorías según el proveedor
        $proveedores = [1,3,6,7,11,13,18];


        return [
            'nombre' => $this->faker->randomElement($nombres), // Nombre del producto
            'precio' => $this->faker->randomElement($precios), // Precio aleatorio de la lista especificada
            'descripcion' => $this->faker->randomElement($descripciones), // Descripción del producto
            'stock' => 0, // Asignar la cantidad de inventario
            'categoria_id' => 2, // Asignar la categoría insumos
            'proveedor_id' => $this->faker->randomElement($proveedores), // ID del proveedor seleccionado
        ];
    }
}
