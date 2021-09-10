<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'category_id',
        'title_id',
        'lawyer_id',
        'client_message',
        'lawyer_response',
        'status',
        'rate',
        'is_rated',
        'is_answered',
    ]; 

    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }

    public function title()
    {
        return $this->belongsTo('App\Model\Title');
    }

    public function lawyer()
    {
        return $this->belongsTo('App\Model\Lawyer');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
