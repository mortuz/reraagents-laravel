<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ExpoToken extends Model
{
    use Notifiable;
    protected $fillable = [
        'device_id',
        'user_id',
        'token'
    ];
}
