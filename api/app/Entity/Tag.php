<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'event_type_id',
        'name',
    ];

    protected $with = [
        'eventType'
    ];

    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'event_type_id', 'id');
    }
}
