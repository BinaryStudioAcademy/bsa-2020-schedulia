<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class CustomFieldValue extends Model
{
    protected $fillable = [
        'custom_field_id',
        'event_id',
        'value'
    ];

    public function customField()
    {
        return $this->belongsTo(CustomField::class);
    }
}
