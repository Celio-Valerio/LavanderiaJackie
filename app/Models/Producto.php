<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'tipo',
        'categoria_id',
        'proveedor_id',
    ];

    /**
     * Relación con el modelo `Categoria`.
     * Un producto pertenece a una categoría.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Relación con el modelo `Proveedor`.
     * Un producto pertenece a un proveedor.
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Relación con el modelo `DetalleCompra`.
     * Un producto puede aparecer en múltiples detalles de compra.
     */
    public function detallesCompra()
    {
        return $this->hasMany(DetalleCompra::class);
    }

    // En el modelo Producto
    public function historialPrecios()
    {
        return $this->hasMany(ProductoPrecioHistorial::class);
    }

}
