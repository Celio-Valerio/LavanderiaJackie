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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->string('numero_factura', 20)->unique(); // Número de factura único, hasta 20 caracteres
            $table->date('fecha_compra'); // Fecha de la compra
            $table->text('descripcion')->nullable(); // Descripción opcional
            $table->unsignedBigInteger('proveedor_id'); // Referencia al proveedor
            $table->timestamps();

            // Definir la relación con la tabla proveedores
            $table->foreign('proveedor_id')->references('id')->on('proveedors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
