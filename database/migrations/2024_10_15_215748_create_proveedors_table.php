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
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100); // Nombre completo del proveedor
            $table->string('email', 100)->nullable()->unique(); // Email opcional y único
            $table->char('phone', 8)->unique(); // Teléfono del proveedor
            $table->string('company_name', 100); // Nombre de la empresa
            $table->char('company_phone', 8)->unique(); // Teléfono de la empresa
            $table->text('company_address'); // Dirección de la empresa
            $table->unsignedBigInteger('categoria_id'); // Referencia a la tabla categorias
            $table->string('city', 50); // Ciudad del proveedor
            // Definir la relación con la tabla categorias
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedors');
    }
};
