<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si es diferente a la convención de nombres de Laravel
    protected $table = 'empleados';

    // Especifica los campos que pueden ser asignados en masa (mass assignable)
    protected $fillable = [
        'first_name',   // Nombres
        'last_name',    // Apellidos
        'email',        // Correo Electrónico
        'phone',        // Teléfono
        'address',      // Dirección
        'position',     // Puesto (debería ser el ID del puesto)
        'hire_date',    // Fecha de ingreso
        'salary',       // Salario
    ];

    // Definición de la relación con el modelo Puesto
    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'puesto_id', 'id'); // Asegúrate de que 'puesto_id' sea la clave foránea
    }
}
