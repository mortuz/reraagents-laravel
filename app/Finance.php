<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
        'name',
        'contact',
        'state_id',
        'city_id',
        'loan_purpose_id',
        'description',
        'user_id'
    ];

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function purpose()
    {
        return $this->belongsTo('App\LoanPurpose', 'loan_purpose_id', 'id');
    }
}
