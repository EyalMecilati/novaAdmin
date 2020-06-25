<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
    protected $casts = [
        'day' => 'date'
    ];
}
