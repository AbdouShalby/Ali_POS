<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoTransaction extends Model
{
    protected $fillable = ['crypto_gateway_id', 'type', 'amount', 'includes_fees'];

    public function cryptoGateway()
    {
        return $this->belongsTo(CryptoGateway::class);
    }
}
