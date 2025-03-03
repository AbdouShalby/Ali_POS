<?php

namespace App\Exports;

use App\Models\Debt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DebtsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Debt::where('status', 'unpaid')->select('id', 'customer_id', 'amount', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            __('reports.debt_id'),
            __('reports.customer'),
            __('reports.amount'),
            __('reports.date'),
        ];
    }
}
