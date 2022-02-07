<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $guarded = [];

    public function fields()
    {
        return $this->hasMany(Field::class);
    }
}
