<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequirementMessage extends Model
{
    protected $fillable = [
        'requirement_id',
        'message',
        'user_id'
    ];

    public function requirement()
    {
        return $this->belongsTo('App\Requirement');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
