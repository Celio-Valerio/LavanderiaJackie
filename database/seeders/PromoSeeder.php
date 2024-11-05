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
        $daysOfWeek = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes'];
        $products = ['Edredones', 'Cortinas', 'Sabanas', 'Pantalones', 'Ropa Interior'];
        $promos = ['Edredones', 'Peluches, almohadas y cojines', 'Lavados y secados + 50 libras'];

        for ($i = 1; $i <= 15; $i++) {
            DB::table('promos')->insert([
                'price' => rand(500, 3000),
                'discount' => rand(10, 30),
                'name' => Arr::random($products), // Sin json_encode
                'libras'=> rand(10, 30),
                'promo' => Arr::random($promos),
                'image' => "promos ($i).JPG",
                'days' => json_encode(Arr::random($daysOfWeek, rand(1, 5))),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
