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
        Schema::create('detalles_gastos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('producto');
            $table->string('numFactura');
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->decimal('descuento', 10, 2);
            $table->unsignedBigInteger('gasto_id');
            $table->timestamps();

            $table->foreign('gasto_id')->references('id')->on('gastos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_gastos');
    }
};
