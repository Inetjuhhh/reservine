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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained('tables');
            $table->foreignId('guest_id')->constrained('guests');
            $table->integer('number_of_guests');
            $table->date('date');
            $table->time('time');
            $table->text('allergies')->nullable();
            $table->boolean('arrived')->default(false);
            $table->enum('status', ['open', 'tobe', 'done', 'archived'])->default('tobe');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
