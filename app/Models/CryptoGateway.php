<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CryptoGateway extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'balance'];

    public function transactions()
    {
        return $this->hasMany(CryptoTransaction::class);
    }

    public function updateBalance($amount)
    {
        $this->balance += $amount;
        $this->save();
    }
}
