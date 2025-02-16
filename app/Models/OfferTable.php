<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferTable extends Model
{
    protected $fillable = [
        'user_id', // The same as users.id
        'currency_from',
        'currency_to',
        'amount',
        'exchange_rate',
        'payment_method',
        'status',
    ];
}
