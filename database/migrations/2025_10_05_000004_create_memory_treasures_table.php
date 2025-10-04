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
        Schema::create('memory_treasures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('couple_id')->constrained('couples')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('heading'); // Main title of the memory
            $table->string('title')->nullable(); // Optional subtitle
            $table->text('description')->nullable(); // Story/description
            $table->date('story_date'); // When this memory happened
            $table->enum('media_type', ['text', 'image', 'audio', 'video'])->default('text');
            $table->string('media_path')->nullable(); // Path to image/audio/video file
            $table->timestamps();
            
            // Index for faster queries
            $table->index(['couple_id', 'story_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memory_treasures');
    }
};
