<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminSettings extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ar',
        'about_app_en',
        'about_app_ar',
        'terms_en',
        'terms_ar',
        'twitter_url',
        'facebook_url',
        'instagram_url',
        'call_us_phone',
        'office_number',
        'fax_number'
    ]; 
}