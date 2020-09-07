<?php

namespace App\Entity;

use App\Constants\EventStatus;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'owner_id',
        'name',
        'color',
        'slug',
        'description',
        'internal_note',
        'duration',
        'timezone',
        'disabled',
        'location_type',
        'coordinates',
        'address',
        'chatito_workspace'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'disabled' => 'boolean',
        'coordinates' => 'json',
        'chatito_workspace' => 'string'
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'owner',
        'availabilities',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'event_type_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'event_type_id');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'event_type_id');
    }

    public function customFields()
    {
        return $this->hasMany(CustomField::class, 'event_type_id');
    }

    public function scheduledEvents()
    {
        return $this->events()->where('status', EventStatus::SCHEDULED);
    }
}
