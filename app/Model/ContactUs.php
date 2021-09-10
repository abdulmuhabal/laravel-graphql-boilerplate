<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'email',
        'subject',
        'message',
    ]; 
}
