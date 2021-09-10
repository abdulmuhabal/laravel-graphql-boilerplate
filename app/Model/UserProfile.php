<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'profile_photo',
        'email',
        'phone',
        'country_code',
        'id_number',
        'birthdate',
        'country_id',
        'city_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }


}