<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Couple extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'couple_name',
        'anniversary_date',
    ];

    protected $casts = [
        'anniversary_date' => 'date',
    ];

    /**
     * Get the first user in the couple.
     */
    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    /**
     * Get the second user in the couple.
     */
    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    /**
     * Get the partner of the given user.
     */
    public function getPartner(User $user): ?User
    {
        if ($this->user_one_id === $user->id) {
            return $this->userTwo;
        } elseif ($this->user_two_id === $user->id) {
            return $this->userOne;
        }
        
        return null;
    }

    /**
     * Check if a user is part of this couple.
     */
    public function hasUser(User $user): bool
    {
        return $this->user_one_id === $user->id || $this->user_two_id === $user->id;
    }

    /**
     * Get all separation requests for this couple.
     */
    public function separationRequests(): HasMany
    {
        return $this->hasMany(HeartSeparation::class);
    }

    /**
     * Get the pending separation request for this couple.
     */
    public function pendingSeparation(): ?HeartSeparation
    {
        return $this->separationRequests()->where('status', 'pending')->first();
    }

    /**
     * Check if there's a pending separation request.
     */
    public function hasPendingSeparation(): bool
    {
        return $this->pendingSeparation() !== null;
    }
}
