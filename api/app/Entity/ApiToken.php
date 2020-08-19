<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    const GOOGLE_SERVICE_ID = 1001;

    protected $fillable = [
        'user_id',
        'service_id',
        'token'
    ];

    public static $services = [
        self::GOOGLE_SERVICE_ID => 'Google'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
