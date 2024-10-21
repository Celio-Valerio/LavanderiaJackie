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
        Schema::create('maquinas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('modelo', 10);
            $table->string('marca');
            $table->text('descripcion')->nullable();
            $table->year('anio_compra');
            $table->string('capacidad')->nullable();
            $table->string('tipo')->nullable();
            $table->enum('estado', ['nuevo', 'usado']);
            $table->string('proveedor');
            $table->string('serie', 10)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquinas');
    }
};
