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
        Schema::create('producto_precio_historials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id'); // Relación con productos
            $table->decimal('precio_anterior', 10, 2); // Precio anterior
            $table->decimal('precio_nuevo', 10, 2); // Nuevo precio
            $table->timestamp('fecha_cambio')->useCurrent(); // Fecha y hora del cambio
            $table->timestamps();

            // Relaciones
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_precio_historials');
    }
};
