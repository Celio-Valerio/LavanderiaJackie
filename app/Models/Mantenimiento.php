<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si es diferente a la convención de nombres de Laravel
    protected $table = 'mantenimientos';

    // Especifica los campos que pueden ser asignados en masa (mass assignable)
    protected $fillable = [
        'date',
        'maquinaria_id', // Clave foránea hacia la tabla maquinarias
        'maintenance_type',
        'description',
        'price',
    ];

    /**
     * Relación inversa uno a muchos con Maquinaria
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function maquinaria()
    {
        return $this->belongsTo(Maquinaria::class, 'maquinaria_id'); // 'maquinaria_id' es el campo en la tabla de mantenimientos
    }
}
