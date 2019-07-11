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
        'added_by'
    ];
}
