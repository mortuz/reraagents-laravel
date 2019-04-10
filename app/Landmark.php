<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Landmark extends Model
{
    protected $fillable = ['name', 'slug', 'state_id', 'city_id'];
}
