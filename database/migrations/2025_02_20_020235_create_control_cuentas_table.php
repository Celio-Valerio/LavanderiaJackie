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
        Schema::create('control_cuentas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha'); // Fecha de la transacción
            $table->enum('transaccion', ['Retiro', 'Deposito', 'Saldo inicial']); // Tipo de transacción
            $table->decimal('monto', 10, 2)->check('monto >= 0.01 AND monto <= 99999.99'); // Monto con validación
            $table->text('notas')->nullable(); // Notas opcionales

            // Columna para la relación con la cuenta bancaria
            $table->unsignedBigInteger('cuenta_banco_id');
            $table->foreign('cuenta_banco_id')->references('id')->on('cuenta_bancos')->onDelete('cascade'); // Relación foránea, eliminar transacción si se elimina la cuenta

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_cuentas');
    }
};
