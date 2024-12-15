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
        Schema::create('detalle_gastos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gasto_id');
            $table->unsignedBigInteger('producto_id');
            $table->Integer('cantidad');
            $table->timestamps();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('gasto_id')->references('id')->on('gastos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_gastos');
    }
};
