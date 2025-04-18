<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('sales.sale_details') }} #{{ $sale->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            direction: rtl;
        }
        .container {
            width: 100%;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .info-section {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }
        th {
            background-color: #f8f9fa;
        }
        .summary {
            float: left;
            width: 300px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ __('sales.sale_details') }} #{{ $sale->id }}</h1>
        </div>

        <div class="info-section">
            <p><strong>{{ __('sales.sale_date') }}:</strong> {{ format_date($sale->created_at) }}</p>
            <p><strong>{{ __('sales.customer') }}:</strong> {{ $sale->customer->name }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('sales.product_name') }}</th>
                    <th>{{ __('sales.quantity') }}</th>
                    <th>{{ __('sales.unit_price') }}</th>
                    <th>{{ __('sales.total_price') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->saleDetails as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ format_currency($item->unit_price) }}</td>
                        <td>{{ format_currency($item->total_price) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <div class="summary-item">
                <span>{{ __('sales.subtotal') }}:</span>
                <span>{{ format_currency($sale->subtotal) }}</span>
            </div>
            <div class="summary-item">
                <span>{{ __('sales.discount') }}:</span>
                <span>{{ format_currency($sale->discount_amount) }}</span>
            </div>
            <div class="summary-item">
                <span>{{ __('sales.tax') }} ({{ $sale->tax_percentage }}%):</span>
                <span>{{ format_currency($sale->tax_amount) }}</span>
            </div>
            <div class="summary-item">
                <strong>{{ __('sales.total') }}:</strong>
                <strong>{{ format_currency($sale->total_amount) }}</strong>
            </div>
        </div>
    </div>
</body>
</html> 