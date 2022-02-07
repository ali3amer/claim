<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
