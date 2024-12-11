<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daysOfWeek = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        $products = ['Edredones', 'Cortinas', 'Sabanas', 'Pantalones', 'Ropa Interior'];
        $promos = ['Edredones', 'Peluches, almohadas y cojines', 'Lavados y secados'];

        for ($i = 1; $i <= 15; $i++) {
            DB::table('promos')->insert([
                'discount' => rand(10, 30),
                'name' => Arr::random($products), // Sin json_encode
                'promo' => Arr::random($promos),
                'image' => "promos ($i).JPG",
                'desde' => rand(10, 15),
                'hasta' => rand(20, 30),
                'days' => json_encode(Arr::random($daysOfWeek, rand(1, 5))),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
