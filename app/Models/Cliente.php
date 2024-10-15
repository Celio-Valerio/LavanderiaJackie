<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si es diferente a la convención de nombres de Laravel
    protected $table = 'clientes';

    // Especifica los campos que pueden ser asignados en masa (mass assignable)
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'type',
    ];
}
