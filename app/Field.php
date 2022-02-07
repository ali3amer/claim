<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $guarded = [];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

}
