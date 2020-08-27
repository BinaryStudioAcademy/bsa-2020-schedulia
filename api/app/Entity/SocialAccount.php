<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    public const GOOGLE_SERVICE_ID = 1001;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'account_id',
        'token',
        'provider',
    ];

    public static $services = [
        self::GOOGLE_SERVICE_ID => 'Google'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
