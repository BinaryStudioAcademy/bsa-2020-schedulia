<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EventCalendar extends Model
{
    protected $fillable = [
        'event_id',
        'provider_id',
        'provider_event_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function scopeGoogle($query)
    {
        return $query->where('provider_id', '=', SocialAccount::GOOGLE_SERVICE_ID);
    }
}
