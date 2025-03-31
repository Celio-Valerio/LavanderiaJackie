<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastoDiario extends Model
{
    use HasFactory;

    protected $fillable = [
        'servicio_efectuado_id',
        'fecha',
        'estado',
    ];

    protected $with = ['detalleGastoDiarios.producto', 'servicioEfectuado.cliente', 'servicioEfectuado.servicio'];


    // GastoDiario.php
    public function detalleGastoDiarios()
    {
        return $this->hasMany(DetalleGastoDiario::class);
    }

    public function servicioEfectuado()
    {
        return $this->belongsTo(ServicioEfectuado::class);
    }


    public function gastoDiario()
    {
        return $this->belongsTo(GastoDiario::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }


// En el modelo ServicioEfectuado
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }


    /**
     * Relación con detalles de gasto diario.
     * Un gasto diario puede tener muchos detalles.
     */
    public function detalles()
    {
        return $this->hasMany(DetalleGastoDiario::class);
    }

    // Método para obtener la suma total en gramos
    public function getTotalGramosAttribute()
    {
        return $this->detalle->sum('cantidad');
    }

}
