<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class create_trades_table extends Model
{
    protected $fillable = [
        'offer_id',
        'buyer_id',
        'seller_id',
        'amount',
        'exchange_rate',
        'payment_status',
        'escrow_status'
    ];


    public function offer()
    {
        return $this->belongsTo(OfferTable::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    // public function seller()
    // {
    //     return $this->belongsTo(User::class, 'seller_id');
    // }
}
