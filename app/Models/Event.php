<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent; // ✅ Correct namespace

class Event extends Eloquent
{
    protected $fillable = [
        'nameOfOrganization',
        'eventDetail',
        'location',
        'date',
        'time',
        'skills',
    ];
}
