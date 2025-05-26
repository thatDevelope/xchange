<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CryptoWallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'wallet_address', 'wallet_name', 'network'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // app/Models/User.php

public function cryptoWallet()
{
    return $this->hasOne(CryptoWallet::class);
}

}
