<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalles_gasto extends Model
{
    use HasFactory;

    public function gasto()
    {
        return $this->belongsTo(Gasto::class);
    }
}
