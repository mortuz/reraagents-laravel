<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable= ['state_id', 'city_id', 'address', 'mobile', 'url', 'govt'];
}
