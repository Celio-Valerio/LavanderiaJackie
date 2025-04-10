<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'numero_factura',
        'fecha_compra',
        'descripcion',
        'proveedor_id',
    ];

    /**
     * Relación con el modelo `Proveedor`.
     * Una compra pertenece a un proveedor.
     */

    /**
     * Relación con el modelo `DetalleCompra`.
     * Una compra tiene muchos detalles de compra.
     */
    // from:
    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class);
    }

// to:
    public function detalle_compras()
    {
        return $this->hasMany(DetalleCompra::class);
    }

    // in app/Models/Compra.php
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }
}
