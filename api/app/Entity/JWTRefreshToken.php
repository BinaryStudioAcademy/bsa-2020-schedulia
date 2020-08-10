<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JWTRefreshToken extends Model
{
    protected $fillable = [
        'user_id', 'token', 'expires_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpiresAt(): string
    {
        return $this->expires_at;
    }
}
