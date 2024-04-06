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
        Schema::create('epresence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_users')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('type', ['IN', 'OUT']);
            $table->boolean('is_approve')->default(true);
            $table->dateTime('waktu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epresence');
    }
};
