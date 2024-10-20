<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    use HasFactory;

    protected $table = 'maquinas';
    protected $fillable = [
        'nombre',
        'marca',
        'modelo',
        'capacidad',
        'estado',
        'proveedor',
        'fecha_adquisicion',
        'serie',
    ];
}

