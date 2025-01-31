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
        Schema::create('servicio_efectuados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade'); // Relación con Cliente
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade'); // Relación con Servicio
            $table->foreignId('promo_id')->nullable()->constrained('promos')->onDelete('set null'); // Relación con Promo (puede ser nula)

            $table->unsignedInteger('libras'); // Libras para el servicio
            $table->text('notas')->nullable(); // Notas adicionales
            $table->enum('estado', ['Pendiente', 'Terminado', 'Entregado']); // Estado del servicio
            $table->enum('envio', ['A domicilio', 'Local']); // Envío a domicilio o local
            $table->decimal('total', 8, 2); // Total del servicio basado en libras y precio del servicio

            $table->text('direccion')->nullable(); // Dirección de envío (si aplica)
            $table->decimal('precio_envio', 8, 2)->nullable()->default(0); // Precio del envío
            $table->enum('pago_envio', ['Cliente', 'Empresa'])->nullable(); // ¿Quién paga el envío?

            $table->date('fecha')->nullable(); // Fecha en que se realizó el servicio
            $table->time('hora')->nullable(); // Hora en que se realizó el servicio
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio_efectuados');
    }
};
