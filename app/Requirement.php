<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $fillable = [
        'state_id',
        'city_id',
        'user_id',
        'mobile',
        'raw_data',
        'inactive',
        'request_delete',
        'call_date',
        'visit_date',
        'working_agent',
        'customer_status_id',
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

    public function workingAgent()
    {
        return $this->belongsTo('App\AgentProfile', 'working_agent', 'id');
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

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments() {
        return $this->hasMany('App\RequirementMessage');
    }
}
