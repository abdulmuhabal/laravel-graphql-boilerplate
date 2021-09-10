<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthOtpCode extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'otp_code'
    ]; 

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
