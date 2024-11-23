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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100); // Nombre del servicio, ejemplo: Lavado, Planchado
            $table->text('descripcion'); // Descripción del servicio
            $table->decimal('precio', 8, 2); // Precio del servicio con dos decimales
            $table->json('articulos')->nullable(); // Artículos que se pueden lavar
            $table->json('extras')->nullable(); // Servicios adicionales disponibles
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
