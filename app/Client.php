<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(Detail::class);
    }

    public function violations()
    {
        return $this->hasMany(Client_Violation::class);
    }
}
