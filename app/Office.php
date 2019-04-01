<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable= ['state_id', 'city_id', 'address', 'mobile', 'url', 'govt'];

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function city()
    {
        return $this->belongsTo('App\city');
    }

    public function hasCity()
    {
        return $this->city;
    }
}
