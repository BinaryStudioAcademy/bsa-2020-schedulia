<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    public const GOOGLE_SERVICE_ID = 1001;
    protected $primaryKey = null;
    public $incrementing = false;

    protected $casts = ['token' => 'json'];

    protected $fillable = [
        'user_id',
        'provider_id',
        'account_id',
        'token',
        'refresh_token'
    ];

    public static $services = [
        self::GOOGLE_SERVICE_ID => 'Google'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGoogle($query)
    {
        return $query->where('provider_id', '=', self::GOOGLE_SERVICE_ID);
    }

    public function getProviderTextAttribute()
    {
        return self::$services[$this->provider_id];
    }
}
