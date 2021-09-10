<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoicePayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'invoice_id',
        'subscription_plan_id',
        'extra_plan_id',
    ]; 
}
