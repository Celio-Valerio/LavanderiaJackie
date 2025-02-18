<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GastoDiario;
use App\Models\DetalleGastoDiario;
use App\Models\ServicioEfectuado;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class GastoDiarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detalle_gasto_diarios')->delete();
        DB::table('gasto_diarios')->delete();

        // Obtener 5 servicios efectuados existentes
        $servicios = ServicioEfectuado::inRandomOrder()->limit(5)->get();
        $productos = Producto::all();

        foreach ($servicios as $servicio) {
            $gasto = GastoDiario::create([
                'servicio_efectuado_id' => $servicio->id,
                'estado' => 'Terminado',
            ]);

            // Generar entre 2 y 5 detalles por gasto diario
            $detallesCount = rand(2, 5);
            $productosUsados = $productos->random($detallesCount);

            foreach ($productosUsados as $producto) {
                DetalleGastoDiario::create([
                    'gasto_diario_id' => $gasto->id,
                    'producto_id' => $producto->id,
                    'cantidad' => rand(1, 10), // Cantidad aleatoria
                    'unidad_medida' => ['kg', 'gramos', 'litros', 'unidades', 'gotas'][rand(0, 4)], // Unidad aleatoria
                ]);
            }
        }
    }
}
