<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    protected $fillable = ['temperature'];
    //protected $dates = ['created_at'];

    public function locations()
    {
        return $this->belongsTo(Location::class,'location_id','id');
    }
}
