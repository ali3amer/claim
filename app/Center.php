<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    protected $guarded = [];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
