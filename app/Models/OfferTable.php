<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfferTable extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'user_id', // The same as users.id
        'order_id',
        'currency_from',
        'currency_to',
        'amount',
        'exchange_rate',
        'payment_method',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function order()
{
    return $this->belongsTo(CurrencyOrder::class, 'order_id');
}

}
