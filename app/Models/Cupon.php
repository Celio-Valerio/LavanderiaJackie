<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cupon extends Model
{
    use HasFactory;

    protected $table = 'cupons';

    protected $fillable = [
        'cliente_id',
        'nombre',
        'descripcion',
        'tipo',
        'valor',
        'cantidad',
    ];

    /**
     * Relación con el modelo Cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
