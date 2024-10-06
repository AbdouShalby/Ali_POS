<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoGateway extends Model
{
    protected $fillable = ['name', 'balance'];

    public function transactions()
    {
        return $this->hasMany(CryptoTransaction::class);
    }
}
