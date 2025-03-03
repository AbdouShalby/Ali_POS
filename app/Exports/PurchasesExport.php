<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchasesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Purchase::select('id', 'supplier_id', 'total_amount', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            __('reports.purchase_id'),
            __('reports.supplier'),
            __('reports.amount'),
            __('reports.date'),
        ];
    }
}
