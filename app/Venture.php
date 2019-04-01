<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venture extends Model
{
    protected $fillable = ['name', 'slug', 'state_id', 'city_id'];
}
