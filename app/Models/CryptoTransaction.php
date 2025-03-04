<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CryptoTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['crypto_gateway_id', 'amount', 'profit_percentage'];

    public function cryptoGateway()
    {
        return $this->belongsTo(CryptoGateway::class);
    }

    public function getProfitAmountAttribute()
    {
        if ($this->profit_percentage) {
            return abs($this->amount) * ($this->profit_percentage / 100);
        }
        return 0;
    }
}
