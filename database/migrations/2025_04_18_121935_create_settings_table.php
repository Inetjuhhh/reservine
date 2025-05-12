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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained();
            $table->string('name');
            $table->text('value');
            $table->enum('type', ['number', 'checkbox', 'text', 'textarea', 'email', 'password', 'file', 'image', 'select', 'radio', 'color', 'date', 'time', 'datetime', 'datetime-local', 'month', 'week', 'url']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
