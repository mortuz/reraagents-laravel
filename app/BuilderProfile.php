<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuilderProfile extends Model
{
    protected $fillable = [ 'state_id', 'city_id', 'user_id', 'contact_no', 'alternative_contact_no'];

    public function ventures()
    {
        return $this->belongsToMany('App\Venture');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }
}
