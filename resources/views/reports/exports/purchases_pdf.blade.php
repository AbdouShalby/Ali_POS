<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('reports.purchases_report') }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h2>{{ __('reports.purchases_report') }}</h2>
<table>
    <thead>
    <tr>
        <th>{{ __('reports.date') }}</th>
        <th>{{ __('reports.supplier') }}</th>
        <th>{{ __('reports.amount') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($purchases as $purchase)
        <tr>
            <td>{{ $purchase->created_at->format('Y-m-d') }}</td>
            <td>{{ $purchase->supplier->name ?? __('reports.unknown') }}</td>
            <td>${{ number_format($purchase->total_amount, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
