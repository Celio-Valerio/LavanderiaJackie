<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleGastos extends Model
{
    use HasFactory;

    public function gasto()
    {
        return $this->belongsTo(Gasto::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
