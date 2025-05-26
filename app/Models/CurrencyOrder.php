<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurrencyOrder extends Model
{
    use HasFactory;
    protected $table = 'currency_orders';

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'currency',
        'currency_amount',
        'exchange_currency',
        'exchange_amount',
        'exchange_rate',
        'total_price',
        'status',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offers()
{
    return $this->hasMany(OfferTable::class, 'order_id');
}

}
