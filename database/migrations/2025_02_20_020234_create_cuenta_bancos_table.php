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
        Schema::create('cuenta_bancos', function (Blueprint $table) {
            $table->id();
            $table->string('banco'); // Nombre del banco
            $table->string('cuenta'); // Número de cuenta
            $table->decimal('saldo', 12, 2)->default(0); // Saldo actual
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuenta_bancos');
    }
};
