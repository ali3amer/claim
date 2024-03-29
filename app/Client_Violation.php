<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client_Violation extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
