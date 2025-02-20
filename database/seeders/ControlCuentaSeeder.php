<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ControlCuenta;
use App\Models\CuentaBanco;
use Carbon\Carbon;

class ControlCuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuentas = CuentaBanco::all(); // Obtener todas las cuentas bancarias

        foreach ($cuentas as $cuenta) {
            $numTransacciones = rand(3, 5); // Entre 3 a 5 transacciones por cuenta

            for ($i = 0; $i < $numTransacciones; $i++) {
                $monto = rand(100, 5000);
                $tipo = ['Retiro', 'Deposito'][rand(0, 1)];

                // Crear una transacción y asociarla con la cuenta
                $transaccion = ControlCuenta::create([
                    'fecha' => Carbon::now()->subDays(rand(1, 30))->toDateString(),
                    'transaccion' => $tipo,
                    'monto' => $monto,
                    'notas' => $tipo == 'Deposito' ? 'Depósito de salario' : 'Retiro para gastos',
                    'cuenta_banco_id' => $cuenta->id, // Asociar la cuenta bancaria a la transacción
                ]);

                // Actualizar el saldo de la cuenta bancaria según el tipo de transacción
                if ($tipo == 'Deposito') {
                    $cuenta->increment('saldo', $monto); // Aumentar saldo por depósito
                } else {
                    $cuenta->decrement('saldo', $monto); // Disminuir saldo por retiro
                }
            }
        }

        $this->command->info('🌱 Transacciones creadas y asociadas correctamente.');
    }
}
