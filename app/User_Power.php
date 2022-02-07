<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_Power extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
