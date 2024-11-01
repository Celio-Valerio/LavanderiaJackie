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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 8, 2)->unsigned()->default(1)->comment('Price from 1 to 30000');
            $table->unsignedTinyInteger('discount')->default(1)->comment('Discount from 1 to 99');
            $table->string('image')->nullable()->comment('Path to the image');
            $table->string('name');
            $table->json('days')->nullable()->comment('Days selected: Monday, Tuesday, Wednesday, etc.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
