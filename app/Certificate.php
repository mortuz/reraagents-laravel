<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'certificate_no',
        'url',
        'state_id',
        'expiry_date',
        'verified'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function getUrlAttribute($url)
    {
        return asset($url);
    }
}
