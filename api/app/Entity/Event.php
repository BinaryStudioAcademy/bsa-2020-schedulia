<?php

namespace App\Entity;

use App\Constants\EventStatus;
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
        'status' => EventStatus::SCHEDULED,
    ];

    protected $with = [
        'eventType'
    ];

    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'event_type_id', 'id');
    }

    public function customFieldValues()
    {
        return $this->hasMany(CustomFieldValue::class, 'event_id');
    }
}
