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
        Schema::create('maquinarias', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Nombre de la maquinaria
            $table->string('type', 50); // Tipo de maquinaria
            $table->enum('status', [
                'Operativa',
                'En mantenimiento',
                'Dada de baja',
                'Pendiente de revisión',
                'En reparación',
                'Fuera de servicio',
                'Requiere repuestos',
                'En espera de piezas',
                'Programada para actualización'
            ]); // Estado de la maquinaria
            $table->date('acquisition_date'); // Fecha de adquisición
            $table->string('brand', 50); // Marca de la maquinaria
            $table->string('model', 50); // Modelo de la maquinaria
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquinarias');
    }
};
