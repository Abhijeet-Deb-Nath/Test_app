<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the couple relationship for this user.
     */
    public function couple(): ?Couple
    {
        return Couple::where('user_one_id', $this->id)
            ->orWhere('user_two_id', $this->id)
            ->first();
    }

    /**
     * Get the partner of this user.
     */
    public function partner(): ?User
    {
        $couple = $this->couple();
        return $couple ? $couple->getPartner($this) : null;
    }

    /**
     * Check if user is in a couple.
     */
    public function isInCouple(): bool
    {
        return $this->couple() !== null;
    }

    /**
     * Get all heart connection requests sent by this user.
     */
    public function sentHeartConnections(): HasMany
    {
        return $this->hasMany(HeartConnection::class, 'sender_id');
    }

    /**
     * Get all heart connection requests received by this user.
     */
    public function receivedHeartConnections(): HasMany
    {
        return $this->hasMany(HeartConnection::class, 'receiver_id');
    }

    /**
     * Get pending heart connection requests received by this user.
     */
    public function pendingHeartConnections(): HasMany
    {
        return $this->receivedHeartConnections()->where('status', 'pending');
    }
}
