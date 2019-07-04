<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PremiumAdRequest extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_id',
        'property_id',
        'invoice_url',
        'paid'
    ];

    public function getUserAttribute()
    {
        return \App\User::find($this->user_id);
    }
}
