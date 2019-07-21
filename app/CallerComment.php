<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallerComment extends Model
{
    protected $fillable = [
        'user_id',
        'call_record_id',
        'comment'
    ];

    public function callRecord()
    {
        $this->belongsTo('App\CallRecord');
    }

    public function addedBy()
    {
        $this->belongsTo('App\User');
    }
}
