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
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 255)->nullable()->unique();
            $table->char('phone', 8)->unique();
            $table->text('address');
            $table->unsignedBigInteger('puesto_id'); // Referencia a la tabla puestos
            $table->date('hire_date'); // Fecha de Ingreso
            $table->decimal('salary', 10, 2); // Salario
            $table->string('identity', 13)->nullable()->unique(); // Identidad
            $table->string('emergency_number', 8)->nullable()->unique(); // Número de emergencia
            $table->string('emergency_contact_name', 100); // Nombre del contacto de emergencia

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

