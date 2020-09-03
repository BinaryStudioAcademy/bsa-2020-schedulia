<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    protected $fillable = ['access_token'];

    public $timestamps = false;
}
