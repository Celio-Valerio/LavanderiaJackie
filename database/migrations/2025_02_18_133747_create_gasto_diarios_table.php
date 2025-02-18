<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gasto_diarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_efectuado_id')->constrained('servicio_efectuados')->onDelete('cascade'); // Relación con servicio efectuado
            $table->enum('estado', ['Pendiente', 'Terminado'])->default('Pendiente'); // Estado del gasto
            $table->date('fecha'); // Fecha en que se realizó el servicio
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gasto_diarios');
    }
};
