<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    // Cambia 'categorias' por 'proveedors'
    protected $table = 'proveedors';

    // Especifica los campos que pueden ser asignados en masa (mass assignable)
    protected $fillable = [
        'full_name',    // Nombre completo
        'email',        // Correo Electrónico
        'phone',        // Teléfono
        'company_name', // Nombre de la empresa
        'company_phone',// Teléfono de la empresa
        'company_address', // Dirección
        'city',         // Ciudad
        'categoria_id'  // ID de la categoría asociada
    ];

    // Relación con la tabla de categorias
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }
}

