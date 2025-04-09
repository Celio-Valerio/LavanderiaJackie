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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->char('identity_number', 13)->unique(); // Número de identidad de Honduras
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 255)->nullable()->unique();
            $table->char('phone', 8)->unique();
            $table->text('address');
            $table->unsignedBigInteger('puesto_id'); // Referencia a la tabla puestos
            $table->date('hire_date'); // Fecha de Ingreso
            $table->date('fecha_salida')->nullable();
            $table->decimal('salary', 10, 2); // Salario
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');

            // Definir la relación con la tabla puestos
            $table->foreign('puesto_id')->references('id')->on('puestos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
