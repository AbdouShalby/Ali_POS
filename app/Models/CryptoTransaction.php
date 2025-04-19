<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CryptoTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'crypto_gateway_id',
        'amount',
        'profit_percentage',
        'type', // 'buy' or 'sell'
        'final_amount',
        'profit_amount'
    ];

    public function cryptoGateway()
    {
        return $this->belongsTo(CryptoGateway::class);
    }

    public function calculateFinalAmount()
    {
        $amount = abs($this->amount);
        $profitAmount = ($amount * abs($this->profit_percentage)) / 100;

        if ($this->type === 'buy') {
            if ($this->profit_percentage > 0) {
                $this->final_amount = $amount + $profitAmount;
            } else {
                $this->final_amount = $amount - $profitAmount;
            }
        } else { // sell
            if ($this->profit_percentage > 0) {
                $this->final_amount = $amount + $profitAmount;
            } else {
                $this->final_amount = $amount - $profitAmount;
            }
        }

        $this->profit_amount = $profitAmount;
        return $this->final_amount;
    }

    public function updateBalances()
    {
        $finalAmount = $this->calculateFinalAmount();

        if ($this->type === 'buy') {
            // إضافة الكمية الأصلية إلى رصيد المحفظة
            $this->cryptoGateway->updateBalance(abs($this->amount));
            
            // خصم الكمية النهائية من الخزنة
            $cashRegister = \App\Models\CashRegister::first();
            if ($cashRegister) {
                $cashRegister->updateBalance('crypto_purchase', -$finalAmount, "شراء عملة مشفرة: {$this->cryptoGateway->name}");
            }
        } else { // sell
            // خصم الكمية الأصلية من رصيد المحفظة
            $this->cryptoGateway->updateBalance(-abs($this->amount));
            
            // إضافة الكمية النهائية إلى الخزنة
            $cashRegister = \App\Models\CashRegister::first();
            if ($cashRegister) {
                $cashRegister->updateBalance('crypto_sale', $finalAmount, "بيع عملة مشفرة: {$this->cryptoGateway->name}");
            }
        }
    }
}
