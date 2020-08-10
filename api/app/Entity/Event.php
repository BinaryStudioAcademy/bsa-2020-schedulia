<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'event_type_id',
        'invitee_name',
        'invitee_email',
        'start_date',
        'timezone',
        'status',
    ];

    protected $attributes = [
        'status' => 'scheduled',
    ];

    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'event_type_id', 'id');
    }
}
