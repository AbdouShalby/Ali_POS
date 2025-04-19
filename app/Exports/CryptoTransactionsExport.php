<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CryptoTransactionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            __('crypto_transactions.gateway'),
            __('crypto_transactions.type'),
            __('crypto_transactions.amount'),
            __('crypto_transactions.profit_percentage'),
            __('crypto_transactions.profit_amount'),
            __('crypto_transactions.final_amount'),
            __('crypto_transactions.date'),
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->cryptoGateway->name,
            __('crypto_transactions.' . $transaction->type),
            number_format($transaction->amount, 8),
            $transaction->profit_percentage . '%',
            number_format($transaction->profit_amount, 8),
            number_format($transaction->final_amount, 8),
            $transaction->created_at->format('Y-m-d H:i'),
        ];
    }
} 