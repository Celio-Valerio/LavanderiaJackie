<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'compra_id',
        'producto_id',
        'cantidad',
        'precio',
        'descuento',
    ];

    /**
     * Relación con el modelo `Compra`.
     * Un detalle de compra pertenece a una compra.
     */
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    /**
     * Relación con el modelo `Producto`.
     * Un detalle de compra está asociado a un producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
