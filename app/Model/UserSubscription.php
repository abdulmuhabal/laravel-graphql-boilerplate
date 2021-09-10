<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_id',
        'expiry_date',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function isExpired()
    {
        if(strtotime($this->expiry_date) > strtotime('now'))
            return false;
        return true;
    }
}
