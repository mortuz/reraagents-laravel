<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentProfile extends Model
{
    protected $fillable = [
        'state_id',
        'city_id',
        'contact_no',
        'address',
        'landmark_id',
        'area_id',
        'premium',
        'pincode',
        'pan',
        'gst',
        'bank_name',
        'account_no',
        'ifsc',
        'user_id'
    ];

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function area()
    {
        return $this->belongsTo('App\Area');
    }

    public function landmark()
    {
        return $this->belongsTo('App\Landmark');
    }
}
