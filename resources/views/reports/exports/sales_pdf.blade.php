<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('reports.sales_report') }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h2>{{ __('reports.sales_report') }}</h2>
<table>
    <thead>
    <tr>
        <th>{{ __('reports.date') }}</th>
        <th>{{ __('reports.customer') }}</th>
        <th>{{ __('reports.amount') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($sales as $sale)
        <tr>
            <td>{{ $sale->created_at->format('Y-m-d') }}</td>
            <td>{{ $sale->customer->name ?? __('reports.unknown') }}</td>
            <td>${{ number_format($sale->total_amount, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
