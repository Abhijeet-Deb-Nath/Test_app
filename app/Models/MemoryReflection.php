<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class MemoryReflection extends Model
{
    use HasFactory;

    protected $fillable = [
        'memory_treasure_id',
        'user_id',
        'reflection_text',
    ];

    /**
     * Get the memory this reflection belongs to.
     */
    public function memoryTreasure(): BelongsTo
    {
        return $this->belongsTo(MemoryTreasure::class);
    }

    /**
     * Get the user who wrote this reflection.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all comments for this reflection.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(MemoryComment::class, 'commentable')->oldest();
    }
}
