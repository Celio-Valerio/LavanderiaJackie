<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cupon;
use Carbon\Carbon;

class CuponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cupones = [
            // Cupones Activos (3)
            [
                'nombre' => 'Descuento Verano',
                'descripcion' => 'Promoción especial de temporada',
                'tipo' => 'Descuento',
                'estado' => 'Activo',
                'valor' => 15.00,
                'fecha_desde' => Carbon::now()->subDays(5),
                'fecha_hasta' => Carbon::now()->addDays(15)
            ],
            [
                'nombre' => 'Lavadas Gratis',
                'tipo' => 'Cantidad',
                'estado' => 'Activo',
                'valor' => 2.00,
                'fecha_desde' => Carbon::now()->subWeek(),
                'fecha_hasta' => Carbon::now()->addMonth()
            ],
            [
                'nombre' => 'Primer Lavado',
                'descripcion' => 'Descuento para nuevos clientes',
                'tipo' => 'Valor',
                'estado' => 'Activo',
                'valor' => 50.00,
                'fecha_desde' => Carbon::today(),
                'fecha_hasta' => Carbon::today()->addMonth()
            ],

            // Cupones Inactivos (3)
            [
                'nombre' => 'Oferta Nocturna',
                'tipo' => 'Valor',
                'estado' => 'Inactivo',
                'valor' => 30.00,
                'fecha_desde' => Carbon::now()->addDays(5),
                'fecha_hasta' => Carbon::now()->addDays(20)
            ],
            [
                'nombre' => 'Pack Familiar',
                'tipo' => 'Cantidad',
                'estado' => 'Inactivo',
                'valor' => 5.00,
                'fecha_desde' => Carbon::now()->subMonth(),
                'fecha_hasta' => Carbon::now()->subDays(10)
            ],
            [
                'nombre' => 'Descuento Flash',
                'tipo' => 'Descuento',
                'estado' => 'Inactivo',
                'valor' => 20.00,
                'fecha_desde' => Carbon::now()->subYear(),
                'fecha_hasta' => Carbon::now()->subMonths(6)
            ],

            // Cupones Utilizados (2)
            [
                'nombre' => 'Lavada Express',
                'tipo' => 'Valor',
                'estado' => 'Utilizado',
                'valor' => 25.00,
                'fecha_desde' => Carbon::now()->subMonth(),
                'fecha_hasta' => Carbon::now()->subWeek()
            ],
            [
                'nombre' => 'Promo Aniversario',
                'descripcion' => 'Celebración de 5 años',
                'tipo' => 'Descuento',
                'estado' => 'Utilizado',
                'valor' => 10.00,
                'fecha_desde' => Carbon::now()->subDays(30),
                'fecha_hasta' => Carbon::now()->subDays(5)
            ],

            // Cupones Vencidos (2)
            [
                'nombre' => 'Oferta Relámpago',
                'tipo' => 'Cantidad',
                'estado' => 'Vencido',
                'valor' => 3.00,
                'fecha_desde' => Carbon::now()->subMonth(2),
                'fecha_hasta' => Carbon::now()->subMonth()
            ],
            [
                'nombre' => 'Fin de Semana',
                'descripcion' => 'Promoción de viernes a domingo',
                'tipo' => 'Valor',
                'estado' => 'Vencido',
                'valor' => 40.00,
                'fecha_desde' => Carbon::now()->subDays(15),
                'fecha_hasta' => Carbon::now()->subDays(3)
            ]
        ];

        foreach ($cupones as $cupon) {
            Cupon::create($cupon);
        }
    }
}
