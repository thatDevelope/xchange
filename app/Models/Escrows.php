<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Escrows extends Model
{

    use HasFactory;

    protected $table = 'escrows';

    protected $fillable = [
        'trade_id',
        'amount',
        'currency',
        'status',
    ];

    const STATUS_HELD = 'held';
    const STATUS_RELEASED = 'released';
    const STATUS_DISPUTED = 'disputed';

    public function trade()
    {
        return $this->belongsTo(create_trades_table::class, 'trade_id');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
