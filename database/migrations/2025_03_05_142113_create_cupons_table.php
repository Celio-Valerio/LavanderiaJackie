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
        Schema::create('cupons', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100); // Nombre del cupón
            $table->text('descripcion')->nullable(); // Descripción del cupón
            $table->enum('tipo', ['Valor', 'Descuento', 'Cantidad']); // Tipo de cupón
            $table->decimal('valor', 8, 2)->nullable(); // Valor del cupón (monto en lempiras o porcentaje)
            $table->unsignedInteger('cantidad')->nullable(); // Cantidad de lavadas si aplica
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade'); // Relación con Cliente
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupons');
    }
};
