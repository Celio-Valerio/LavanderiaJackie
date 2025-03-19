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
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['Valor', 'Descuento', 'Cantidad']);
            $table->enum('estado', ['Activo', 'Inactivo', 'Utilizado', 'Vencido']);
            $table->decimal('valor', 8, 2)->nullable();
            $table->date('fecha_desde');
            $table->date('fecha_hasta');
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
