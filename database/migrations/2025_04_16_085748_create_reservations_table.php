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
            $table->foreignId('table_id')->nullable()->constrained('tables');
            $table->foreignId('guest_id')->default(1)->constrained('guests');
            $table->integer('number_of_guests')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->text('allergies')->nullable();
            $table->boolean('arrived')->default(false);
            $table->enum('status', ['to arrive', 'open', 'payed', 'archived', 'cancelled'])->default('to arrive');
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
