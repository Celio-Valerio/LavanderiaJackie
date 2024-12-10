<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;

    protected $table = 'gastos';

    // Atributos que se pueden asignar masivamente
    protected $fillable = [
        'descripcion',
        'monto',
        'totalAmount',
        'fecha',
        'categoria_id',
        
    ];

    // Relación con la tabla de categorías
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Método para obtener el monto formateado
    public function getMontoFormateadoAttribute()
    {
        return number_format($this->monto, 2);
    }
    public function detalles()
    {
        return $this->hasMany(Detalles_gasto::class);
    }
}
