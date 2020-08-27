<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = [
        'event_type_id',
        'name',
        'type'
    ];

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function customFieldValue()
    {
        return $this->hasOne(CustomFieldValue::class, 'custom_field_id');
    }
}
