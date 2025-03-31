<?php

namespace Database\Seeders;

use App\Models\DetalleGastoDiario;
use App\Models\GastoDiario;
use App\Models\Producto;
use App\Models\ServicioEfectuado;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GastoDiarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('detalle_gasto_diarios')->delete();
        DB::table('gasto_diarios')->delete();

        $servicios = ServicioEfectuado::inRandomOrder()->limit(5)->get();
        $productos = Producto::all();

        foreach ($servicios as $servicio) {
            // Crear gasto diario con fecha aleatoria de los últimos 30 días
            $gasto = GastoDiario::create([
                'servicio_efectuado_id' => $servicio->id,
                'estado' => 'Terminado',
                'fecha' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d')
            ]);

            // Crear entre 2 y 5 detalles por gasto
            $productos->random(rand(2, 5))->each(function ($producto) use ($gasto) {
                DetalleGastoDiario::create([
                    'gasto_diario_id' => $gasto->id,
                    'producto_id' => $producto->id,
                    'cantidad' => rand(1, 1000) / 100, // Ej: 12.34
                    'unidad_medida' => ['kg', 'gr', 'lt', 'unidades', 'ml'][rand(0, 4)],
                ]);
            });
        }
    }
}
