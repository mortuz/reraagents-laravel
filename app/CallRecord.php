<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallRecord extends Model
{
    protected $table = 'call_records';
    
    protected $fillable = [
        'state_id',
        'city_id',
        'designation_id',
        'mobile',
        'comment',
        'paid_user',
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

    public function designation()
    {
        return $this->belongsTo('App\Designation');
    }

    public function comments()
    {
        return $this->hasMany('App\CallerComment');
    }
}
