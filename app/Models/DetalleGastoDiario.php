<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleGastoDiario extends Model
{
    use HasFactory;

    protected $fillable = [
        'gasto_diario_id',
        'producto_id',
        'cantidad',
        'unidad_medida',
    ];

    /**
     * Relación con gasto diario.
     * Un detalle de gasto diario pertenece a un gasto diario.
     */
    public function gastoDiario()
    {
        return $this->belongsTo(GastoDiario::class);
    }


    /**
     * Relación con producto.
     * Un detalle de gasto diario está relacionado con un producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
