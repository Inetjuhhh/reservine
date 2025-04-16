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
        Schema::create('reservation_meal_ingredient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_meal_id')->constrained('reservation_meal');
            $table->foreignId('ingredient_id')->constrained('ingredients');
            $table->enum('action', ['add', 'remove', 'replace']);
            $table->string('replacement_ingredient')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_meal_ingredient');
    }
};
