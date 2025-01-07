<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    protected $fillable = ['transaction_type', 'amount', 'balance', 'description'];

    public static function updateBalance($transactionType, $amount, $description = null)
    {
        $lastTransaction = self::latest()->first();
        $currentBalance = $lastTransaction ? $lastTransaction->balance : 0;

        $newBalance = $currentBalance + $amount;

        self::create([
            'transaction_type' => $transactionType,
            'amount' => $amount,
            'balance' => $newBalance,
            'description' => $description,
        ]);
    }

    public static function getTodayTotals()
    {
        $todayTransactions = self::whereDate('created_at', now()->toDateString())->get();

        $totalIn = $todayTransactions->where('amount', '>', 0)->sum('amount');
        $totalOut = $todayTransactions->where('amount', '<', 0)->sum('amount');
        $netTotal = $totalIn + $totalOut;

        return [
            'total_in' => $totalIn,
            'total_out' => $totalOut,
            'net_total' => $netTotal,
        ];
    }

    public static function getOverallTotals()
    {
        $totalIn = self::where('amount', '>', 0)->sum('amount');
        $totalOut = self::where('amount', '<', 0)->sum('amount');
        $netBalance = self::latest()->first()?->balance ?? 0;

        return [
            'total_in' => $totalIn,
            'total_out' => $totalOut,
            'net_balance' => $netBalance,
        ];
    }

}
