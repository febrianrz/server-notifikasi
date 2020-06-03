<?php

namespace App;

use Febrianrz\Makeapi\HasUUID;
use Illuminate\Database\Eloquent\Model;

class WebNotification extends Model
{
    use HasUUID;
    protected $primaryKey = 'id';

    protected $fillable = [
        'to',
        'title',
        'content',
        'type',
        'link'
    ];

    public $incrementing = false;
}
