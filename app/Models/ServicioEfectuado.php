<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioEfectuado extends Model
{
    use HasFactory;

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'cliente_id',
        'servicio_id',
        'promo_id',
        'libras',
        'notas',
        'estado',
        'envio',
        'total',
        'fecha',
        'hora',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    // Relación con el modelo Promo (si aplica)
    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public function gastosDiarios()
    {
        return $this->hasMany(GastoDiario::class);
    }

    // Método para calcular el total en base a las libras y el precio del servicio
    public function calcularTotal()
    {
        // Obtener el precio del servicio asociado
        $precioServicio = $this->servicio->precio;

        // Calcular el total en base a las libras
        return $precioServicio * $this->libras;
    }

    // Mutador para calcular el total automáticamente al guardar el servicio efectuado
    public function setTotalAttribute($value)
    {
        // Si el valor de total no se pasa explícitamente, calcularlo
        if (!$value) {
            $this->attributes['total'] = $this->calcularTotal();
        } else {
            $this->attributes['total'] = $value;
        }
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

// DetalleServicio.php
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
