<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $casts = [
        'is_active' => 'boolean'
    ];
}
