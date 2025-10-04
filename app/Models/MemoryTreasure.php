<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

class MemoryTreasure extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_id',
        'created_by',
        'heading',
        'title',
        'description',
        'story_date',
        'media_type',
        'media_path',
    ];

    protected $casts = [
        'story_date' => 'date',
    ];

    /**
     * Get the couple this memory belongs to.
     */
    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }

    /**
     * Get the user who created this memory.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all reflections for this memory.
     */
    public function reflections(): HasMany
    {
        return $this->hasMany(MemoryReflection::class)->oldest();
    }

    /**
     * Get all comments for this memory.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(MemoryComment::class, 'commentable')->oldest();
    }

    /**
     * Check if this memory has media (image/audio/video).
     */
    public function hasMedia(): bool
    {
        return in_array($this->media_type, ['image', 'audio', 'video']) && !empty($this->media_path);
    }

    /**
     * Get the full URL for the media file.
     */
    public function getMediaUrl(): ?string
    {
        if (!$this->hasMedia()) {
            return null;
        }

        return Storage::url($this->media_path);
    }

    /**
     * Check if the memory is text-only.
     */
    public function isTextOnly(): bool
    {
        return $this->media_type === 'text';
    }

    /**
     * Check if the memory has an image.
     */
    public function hasImage(): bool
    {
        return $this->media_type === 'image';
    }

    /**
     * Check if the memory has audio.
     */
    public function hasAudio(): bool
    {
        return $this->media_type === 'audio';
    }

    /**
     * Check if the memory has video.
     */
    public function hasVideo(): bool
    {
        return $this->media_type === 'video';
    }

    /**
     * Get the display icon for the media type.
     */
    public function getMediaIcon(): string
    {
        return match($this->media_type) {
            'image' => '📸',
            'audio' => '🎵',
            'video' => '🎬',
            default => '📝',
        };
    }

    /**
     * Delete the media file when the memory is deleted.
     */
    protected static function booted()
    {
        static::deleting(function ($memory) {
            if ($memory->hasMedia() && Storage::exists($memory->media_path)) {
                Storage::delete($memory->media_path);
            }
        });
    }
}
