<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'price',
        'vat',
        'total_price',
        'paid',
        'transaction_id',
        'tin_number',
        'order_number',
    ]; 
}
