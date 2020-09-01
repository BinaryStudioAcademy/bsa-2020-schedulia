<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EventCalendars extends Model
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
}
