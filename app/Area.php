<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['area', 'slug', 'state_id', 'city_id'];
}
