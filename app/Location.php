<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['country','city'];

    public function temperatures()
    {
        return $this->hasMany(Temperature::class);
    }
}

