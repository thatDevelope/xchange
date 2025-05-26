<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VirtualWallet extends Model
{
    protected $fillable = [
        'wallet_reference',
        'wallet_name',
        'customer_name',
        'customer_email',
        'bvn',
        'bvn_dob',
        'account_number',
        'account_name'
    ];
}
