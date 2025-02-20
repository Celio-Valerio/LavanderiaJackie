<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CuentaBanco;

class CuentaBancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bancos = [
            'Banco Atlántida',
            'BAC Credomatic',
            'Banco Ficohsa',
            'Banco de Occidente',
            'Banco Lafise'
        ];

        foreach ($bancos as $banco) {
            CuentaBanco::create([
                'banco' => $banco,
                'cuenta' => rand(1000000000, 9999999999),
                'saldo' => rand(5000, 50000)
            ]);
        }

        $this->command->info('🏦 Cuentas bancarias creadas exitosamente.');
    }
}
