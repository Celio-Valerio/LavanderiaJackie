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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Fecha del mantenimiento
            $table->unsignedBigInteger('maquinaria_id'); // Referencia a la tabla maquinarias

            $table->enum('maintenance_type', [
                'Preventivo',
                'Correctivo',
                'Emergencia'
            ]); // Tipo de mantenimiento
            $table->text('description'); // Descripción del mantenimiento
            $table->decimal('price', 10, 2); // Precio del mantenimiento
            // Definir la relación con la tabla maquinarias
            $table->foreign('maquinaria_id')->references('id')->on('maquinarias')->onDelete('cascade');

            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
