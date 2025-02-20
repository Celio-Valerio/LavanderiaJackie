<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaBanco extends Model
{
    use HasFactory;

    protected $fillable = ['banco', 'cuenta', 'saldo'];

    // Relación uno a muchos: una cuenta bancaria tiene muchas transacciones
    public function controlCuentas()
    {
        return $this->hasMany(ControlCuenta::class, 'cuenta_banco_id');
    }

    // Relación con el modelo ControlCuenta (Transacciones)
    public function transacciones()
    {
        return $this->hasMany(ControlCuenta::class, 'cuenta_banco_id'); // Relación 1:N
    }

    // Método para actualizar el saldo de la cuenta bancaria
    public function actualizarSaldo($monto, $tipo)
    {
        if ($tipo === 'Deposito') {
            $this->saldo += $monto;
        } elseif ($tipo === 'Retiro' && $this->saldo >= $monto) {
            $this->saldo -= $monto;
        } else {
            throw new \Exception("Saldo insuficiente para el retiro.");
        }
        $this->save();
    }
}
