<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquinaria extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si es diferente a la convención de nombres de Laravel
    protected $table = 'maquinarias';

    // Especifica los campos que pueden ser asignados en masa (mass assignable)
    protected $fillable = [
        'name',
        'type',
        'status',
        'acquisition_date',
        'brand',
        'model',
    ];

    /**
     * Relación uno a muchos con Mantenimiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'maquinaria_id', 'id'); // Clave foránea correcta
    }
}
