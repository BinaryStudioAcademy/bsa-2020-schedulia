<?php

namespace App\Entity;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyNotification;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail, CanResetPassword
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'timezone',
        'slack_webhook',
        'slack_channel',
        'slack_active',
        'chatito_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'slack_active' => 'bool',
        'chatito_active' => 'bool'
    ];

    public function refreshTokens(): HasMany
    {
        return $this->hasMany(JWTRefreshToken::class, 'user_id', 'id');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function eventTypes()
    {
        return $this->hasMany(EventType::class, 'owner_id', 'id');
    }

    public function apiTokens()
    {
        return $this->hasMany(ApiToken::class);
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function googleAccounts()
    {
        return $this->socialAccounts()->google();
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyNotification());
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatar ? Storage::disk()->url($this->avatar) : null;
    }

    public function getBrandingLogoUrl(): ?string
    {
        return $this->branding_logo ? Storage::disk()->url($this->branding_logo) : null;
    }

    public function routeNotificationForSlack($notification = null)
    {
        return $this->slack_webhook;
    }
}
