<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si es diferente a la convención de nombres de Laravel
    protected $table = 'categorias';

    // Especifica los campos que pueden ser asignados en masa (mass assignable)
    protected $fillable = [
        'name',        // Nombre de la categoria
        'description', // Descripción de la categoria
    ];

    // Si hay una relación con proveedores, puedes definirla aquí
    public function proveedores()
    {
        return $this->hasMany(Proveedor::class, 'categoria_id', 'id');
    }

}
