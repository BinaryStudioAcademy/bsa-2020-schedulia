<?php

namespace App\Entity;

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
        'duration',
        'timezone',
        'disabled',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'disabled' => 'boolean',
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'owner',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
