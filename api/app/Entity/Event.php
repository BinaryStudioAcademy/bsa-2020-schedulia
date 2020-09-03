<?php

namespace App\Entity;

use App\Constants\EventStatus;
use Carbon\Carbon;
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
        'location'
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

    public function calendars()
    {
        return $this->hasMany(EventCalendar::class);
    }

    public function googleCalendars()
    {
        return $this->calendars()->google();
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', '=', EventStatus::SCHEDULED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', '=', EventStatus::CANCELLED);
    }

    public function getEventTimeAccordingTimezoneAttribute(): string
    {
        $utcTime = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date, 'UTC');
        $utcTime->setTimezone($this->timezone);
        return $utcTime->toDateTimeString();
    }
}
