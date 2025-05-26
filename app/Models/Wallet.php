<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Wallet extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'wallets';

    // Define the fillable properties (columns we can mass assign)
    protected $fillable = [
        'user_id', 'wallet_id', 'type', 'balance'
    ];


    protected static function booted()
    {
        static::creating(function ($wallet) {
            if (!$wallet->wallet_id) {
                $wallet->wallet_id = Str::uuid(); // Generate UUID if it's not set
            }
        });
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
