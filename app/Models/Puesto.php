<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si es diferente a la convención de nombres
    protected $table = 'puestos';

    // Especifica los campos que pueden ser asignados en masa (mass assignable)
    protected $fillable = [
        'name',        // Nombre del puesto
        'description', // Descripción del puesto
    ];

    // Si hay una relación con empleados, puedes definirla aquí
    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'puesto_id', 'id');
    }
}
