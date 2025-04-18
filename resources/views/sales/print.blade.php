<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('sales.invoice') }} #{{ $sale->id }}</title>
    <style>
        @page {
            margin: 0.5cm;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 30px;
            color: #2B3674;
            background-color: #fff;
        }
        
        .rtl {
            direction: rtl;
            text-align: right;
        }
        
        .invoice-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #E9EDF7;
            box-shadow: 0 0 20px rgba(43, 54, 116, 0.05);
            border-radius: 10px;
            background-color: #fff;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #E9EDF7;
        }
        
        .header h2 {
            margin: 0;
            color: #2B3674;
            font-size: 28px;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0;
            color: #707EAE;
            font-size: 14px;
        }
        
        .invoice-details {
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
        }
        
        .invoice-details-left, .invoice-details-right {
            flex: 1;
        }
        
        .invoice-details h3 {
            color: #2B3674;
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .invoice-details p {
            margin: 8px 0;
            color: #707EAE;
            font-size: 14px;
        }
        
        .invoice-details strong {
            color: #2B3674;
            font-weight: 600;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: #fff;
        }
        
        th {
            background-color: #F4F7FE;
            color: #2B3674;
            font-weight: 600;
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid #E9EDF7;
            font-size: 14px;
        }
        
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #E9EDF7;
            color: #707EAE;
            font-size: 14px;
        }
        
        .rtl th, .rtl td {
            text-align: right;
        }
        
        .item-row:hover {
            background-color: #F4F7FE;
        }
        
        .totals {
            float: right;
            width: 350px;
            margin-top: 20px;
        }
        
        .rtl .totals {
            float: left;
        }
        
        .totals table {
            margin-bottom: 0;
            background-color: #F4F7FE;
            border-radius: 10px;
        }
        
        .totals th {
            text-align: right;
            width: 50%;
            background-color: transparent;
            border: none;
            color: #707EAE;
            font-weight: normal;
        }
        
        .totals td {
            text-align: right;
            border: none;
            color: #2B3674;
            font-weight: 600;
        }
        
        .rtl .totals th, .rtl .totals td {
            text-align: left;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #707EAE;
            font-size: 14px;
            border-top: 2px solid #E9EDF7;
            padding-top: 20px;
        }
        
        .print-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 12px 24px;
            background-color: #4318FF;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(67, 24, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .print-button:hover {
            background-color: #3311CC;
            box-shadow: 0 6px 15px rgba(67, 24, 255, 0.3);
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-paid {
            background-color: #E6F9F0;
            color: #01B574;
        }
        
        .status-pending {
            background-color: #FFF6E5;
            color: #FFB547;
        }
        
        @media print {
            body {
                padding: 0;
                background-color: #fff;
            }
            
            .invoice-container {
                box-shadow: none;
                border: none;
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body class="{{ app()->getLocale() == 'ar' ? 'rtl' : '' }}">
    <div class="invoice-container">
        <div class="header">
            <h2>{{ $company['name'] }}</h2>
            <p>{{ $company['address'] }}</p>
            <p>{{ __('dashboard.phone') }}: {{ $company['phone'] }}</p>
            <p>{{ __('dashboard.email') }}: {{ $company['email'] }}</p>
            <p>{{ __('dashboard.tax_number') }}: {{ $company['tax_number'] }}</p>
        </div>

        <div class="invoice-details">
            <div class="invoice-details-left">
                <h3>{{ __('sales.invoice') }} #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</h3>
                <p><strong>{{ __('sales.date') }}:</strong> {{ $sale->created_at->format('Y-m-d H:i') }}</p>
                @if($sale->customer)
                    <p><strong>{{ __('customers.name') }}:</strong> {{ $sale->customer->name }}</p>
                @endif
                @if($sale->warehouse)
                    <p><strong>{{ __('warehouses.warehouse') }}:</strong> {{ $sale->warehouse->name }}</p>
                @endif
            </div>
            <div class="invoice-details-right" style="text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                <div class="status-badge status-paid">
                    {{ __('sales.paid') }}
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('products.product') }}</th>
                    <th>{{ __('sales.quantity') }}</th>
                    <th>{{ __('sales.unit_price') }}</th>
                    <th>{{ __('sales.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->saleItems as $index => $item)
                <tr class="item-row">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <th>{{ __('sales.subtotal') }}:</th>
                    <td>{{ number_format($sale->subtotal, 2) }}</td>
                </tr>
                @if($sale->tax_amount > 0)
                <tr>
                    <th>{{ __('sales.tax') }} ({{ $sale->tax_percentage }}%):</th>
                    <td>{{ number_format($sale->tax_amount, 2) }}</td>
                </tr>
                @endif
                @if($sale->discount_amount > 0)
                <tr>
                    <th>{{ __('sales.discount') }}:</th>
                    <td>{{ number_format($sale->discount_amount, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <th style="color: #2B3674; font-weight: 600;">{{ __('sales.total') }}:</th>
                    <td style="color: #4318FF; font-weight: 700; font-size: 16px;">{{ number_format($sale->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div style="clear: both;"></div>

        <div class="footer">
            <p>{{ __('sales.thank_you') }}</p>
            @if($company['name'])
                <p>{{ $company['name'] }}</p>
            @endif
        </div>
    </div>

    <button class="print-button no-print" onclick="window.print()">
        {{ __('sales.print') }}
    </button>
</body>
</html> 