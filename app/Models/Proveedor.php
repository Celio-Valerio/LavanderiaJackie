<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedors';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'company_name',
        'company_phone',
        'company_address',
        'city',
        'categoria_id'
    ];

    // Relación con categorias
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }

    // Relación con maquinarias
    public function maquinarias()
    {
        return $this->hasMany(Maquinaria::class, 'proveedor_id', 'id');
    }
}
