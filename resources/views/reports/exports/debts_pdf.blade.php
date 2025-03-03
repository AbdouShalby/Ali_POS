<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('reports.debts_report') }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h2>{{ __('reports.debts_report') }}</h2>
<table>
    <thead>
    <tr>
        <th>{{ __('reports.date') }}</th>
        <th>{{ __('reports.customer') }}</th>
        <th>{{ __('reports.amount') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($debts as $debt)
        <tr>
            <td>{{ $debt->created_at->format('Y-m-d') }}</td>
            <td>{{ $debt->customer->name ?? __('reports.unknown') }}</td>
            <td>${{ number_format($debt->amount, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
