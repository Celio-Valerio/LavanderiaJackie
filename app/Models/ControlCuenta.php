<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlCuenta extends Model
{
    use HasFactory;

    protected $fillable = ['fecha', 'transaccion', 'monto', 'notas', 'cuenta_banco_id'];

    // Relación inversa: una transacción pertenece a una sola cuenta bancaria
    public function cuentaBanco()
    {
        return $this->belongsTo(CuentaBanco::class, 'cuenta_banco_id');
    }
}
