<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogNotification extends Model
{
    use SoftDeletes;

    public function userToNotify()
    {
        return $this->belongsTo('App\User','user_id_to_notify');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
