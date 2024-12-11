<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoPrecioHistorial extends Model
{
    use HasFactory;

    protected $table = 'producto_precio_historials';

    protected $fillable = [
        'producto_id',
        'precio_anterior',
        'precio_nuevo',
        'fecha_cambio',
    ];

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
