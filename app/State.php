<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name', 'slug', 'status'];

    public function cities()
    {
        return $this->hasMany('App\City');
    }
}
