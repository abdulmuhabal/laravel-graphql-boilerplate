<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Model\AuthOtpCode;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable;
    
    protected $fillable = [
        'role',
        'email',
        'phone',
        'country_code',
        'password',
        'is_verified',
        
    ]; 

    protected $hidden = [
        'password'
    ];

    protected $appends = [
        'is_subscribed',  
    ];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {
            // 
            
        });
        
    }

    public function hasRole($role)
    {
        if ($this->role == $role) {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        return $this->hasRole('ADMIN');
    }

    public function isClient()
    {
        return $this->hasRole('CLIENT');
    }

    public function userProfile()
    {
        return $this->hasOne('App\Model\UserProfile','user_id');
    }

    public function userSubscriptions()
    {
        return $this->hasMany('App\Model\UserSubscription','user_id');
    }

    public function lastSubscription()
    {
        return $this->userSubscriptions()->latest('id')->first();
    }

    public function getIsSubscribedAttribute()
    {
        if($this->lastSubscription()){
            return !$this->lastSubscription()->isExpired();
        }
        return false;     
    }

    public function getOtpCodeAttribute()
    {   
        $auth_otp = AuthOtpCode::where('user_id',$this->id)
        ->where('expired',false)
        ->where('created_at','>=', '(NOW(), INTERVAL 60 SECOND)')
        ->first();
        if($auth_otp){
            return $auth_otp->otp_code;
        }
        return null;
    }






}
