<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visita extends Model
{
    use HasFactory;

    protected $table = 'visitas';

    protected $fillable = [
        'cliente_id',
        'visitas_totales',
        'visitas_disponibles',

    ];

    protected $casts = [
        'fecha_visita' => 'datetime',
    ];

    /**
     * Relación con el modelo Cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
