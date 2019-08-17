<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = [
        'state_id', 
        'city_id', 
        'address', 
        'mobile', 
        'url', 
        'govt', 
        'map', 
        'verified',
        'verified_at',
        'user_id',
        'coordinates',
        'name'
    ];

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }
    public function agent()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function hasCity()
    {
        return $this->city;
    }
}
