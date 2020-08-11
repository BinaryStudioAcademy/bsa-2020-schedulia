<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = [
        'event_type_id',
        'type',
        'start_date',
        'end_date',
    ];

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }
}
