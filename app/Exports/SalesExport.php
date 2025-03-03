<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Sale::select('id', 'customer_id', 'total_amount', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            __('reports.sale_id'),
            __('reports.customer'),
            __('reports.amount'),
            __('reports.date'),
        ];
    }
}
