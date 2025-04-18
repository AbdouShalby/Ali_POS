<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $sale;

    public function __construct($sale)
    {
        $this->sale = $sale;
    }

    public function collection()
    {
        return $this->sale->saleDetails;
    }

    public function headings(): array
    {
        return [
            '#',
            __('sales.product_name'),
            __('sales.quantity'),
            __('sales.unit_price'),
            __('sales.total_price'),
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->product->name,
            $item->quantity,
            $item->unit_price,
            $item->total_price,
        ];
    }
}
