<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'state_id',
        'city_id',
        'user_id',
        'mobile',
        'raw_data',
        'for_sale',
        'features',
        'youtube_link',
        'google_map',
        'website',
        'images',
        'premium',
        'expiry_date',
        'handled_by',
        'status'
    ];

    public function areas()
    {
        return $this->belongsToMany('App\Area');
    }

    public function landmarks()
    {
        return $this->belongsToMany('App\Landmark');
    }

    public function prices()
    {
        return $this->belongsToMany('App\Price');
    }

    public function propertytypes()
    {
        return $this->belongsToMany('App\PropertyType');
    }

    public function rooms()
    {
        return $this->belongsToMany('App\BHK');
    }

    public function faces()
    {
        return $this->belongsToMany('App\Face');
    }

    public function builders()
    {
        return $this->belongsToMany('App\BuilderProfile');
    }

    public function agents()
    {
        return $this->belongsToMany('App\AgentProfile');
    }

    public function ventures()
    {
        return $this->belongsToMany('App\Venture');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function feedback()
    {
        return $this->belongsTo('App\Feedback');
    }
}
