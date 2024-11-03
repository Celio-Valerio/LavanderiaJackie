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
        Schema::create('detalle_compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compra_id'); // Referencia a la compra
            $table->unsignedBigInteger('producto_id'); // ID del producto o insumo
            $table->integer('cantidad'); // Cantidad del producto
            $table->decimal('precio', 10, 2); // Precio del producto
            $table->decimal('descuento', 10, 2)->nullable(); // Descuento opcional
            $table->timestamps();

            // Definir la relación con la tabla compras
            $table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade');
            // Definir la relación con la tabla productos o insumos (ajustar según el nombre de la tabla específica)
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_compras');
    }
};
