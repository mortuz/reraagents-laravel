<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'role', 'state_id', 'city_id', 'designation_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function findForPassport($identifier)
    {
        return $this->orWhere('email', $identifier)->orWhere('mobile', $identifier)->first();
    }
    
    public function agent()
    {
        return $this->belongsTo('App\AgentProfile', 'id', 'user_id');
    }

    public function certificates()
    {
        return $this->hasMany('App\Certificate');
    }

    // public function tokens()
    // {
    //     return $this->hasMany('App\ExpoToken');
    // }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function AauthAcessToken()
    {
        return $this->hasMany('\App\OauthAccessToken');
    }

    public function designation()
    {
        return $this->belongsToMany('App\Designation');
    }
}
