<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $primaryKey = 'id';

    protected $guarded = [];

    public $incrementing = true;

    public function channel()
    {
        return $this->belongsTo(Channel::class,'channel_id');
    }
}
