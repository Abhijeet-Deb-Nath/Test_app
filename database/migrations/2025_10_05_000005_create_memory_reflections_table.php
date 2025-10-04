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
        Schema::create('memory_reflections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memory_treasure_id')->constrained('memory_treasures')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('reflection_text'); // The nostalgic thought/recalling text
            $table->timestamps();
            
            // Index for faster queries
            $table->index('memory_treasure_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memory_reflections');
    }
};
