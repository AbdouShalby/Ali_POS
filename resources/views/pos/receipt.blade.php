<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - فاتورة #{{ $sale->id }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo:300,400,500,600,700" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        @page {
            size: 80mm 297mm; /* حجم الورق المستخدم للفواتير الحرارية */
            margin: 0;
        }
        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
            background-color: #f5f5f5;
        }
        .receipt {
            width: 80mm;
            margin: 0 auto;
            background: #fff;
            padding: 5mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 5mm;
            padding-bottom: 3mm;
            border-bottom: 1px solid #eee;
        }
        .receipt-header img {
            max-width: 20mm;
            margin-bottom: 2mm;
        }
        .receipt-header h1 {
            font-size: 16pt;
            margin: 0;
            font-weight: 700;
            color: #009ef7;
        }
        .receipt-header p {
            font-size: 9pt;
            margin: 2mm 0;
            color: #555;
        }
        .receipt-details {
            margin-bottom: 5mm;
            border-bottom: 1px dashed #ccc;
            padding: 3mm 0;
        }
        .receipt-details p {
            margin: 2mm 0;
            font-size: 9pt;
            display: flex;
            justify-content: space-between;
        }
        .receipt-items {
            margin-bottom: 5mm;
        }
        .receipt-items table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .receipt-items th {
            text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
            padding: 2mm;
            border-bottom: 1px solid #eee;
            background-color: #f9f9f9;
            font-weight: 600;
            color: #009ef7;
        }
        .receipt-items td {
            padding: 2mm;
            border-bottom: 1px solid #eee;
        }
        .receipt-items .text-end {
            text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};
        }
        .receipt-items tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .receipt-items tr:hover {
            background-color: #f5f5f5;
        }
        .receipt-total {
            margin-top: 3mm;
            border-top: 1px dashed #ccc;
            padding-top: 3mm;
        }
        .receipt-total p {
            margin: 2mm 0;
            font-size: 9pt;
            display: flex;
            justify-content: space-between;
        }
        .receipt-total .total {
            font-weight: bold;
            font-size: 12pt;
            color: #009ef7;
        }
        .receipt-total .total span:last-child {
            font-size: 14pt;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 5mm;
            font-size: 9pt;
            border-top: 1px dashed #ccc;
            padding-top: 3mm;
            color: #555;
        }
        .receipt-footer p {
            margin: 2mm 0;
        }
        .barcode {
            text-align: center;
            margin: 5mm 0;
        }
        .barcode img {
            max-width: 100%;
            height: 15mm;
        }
        .qr-code {
            text-align: center;
            margin: 5mm 0;
        }
        .qr-code img {
            width: 25mm;
            height: 25mm;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
                background-color: white;
            }
            .no-print {
                display: none;
            }
            .receipt {
                width: 100%;
                box-shadow: none;
                padding: 0;
                margin: 0;
            }
            .receipt-items tr:hover {
                background-color: inherit;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <img src="{{ asset('media/logos/logo.png') }}" alt="{{ config('app.name') }}">
            <h1>{{ config('app.name') }}</h1>
            <p>{{ app()->getLocale() == 'ar' ? 'نظام نقاط البيع الاحترافي' : 'Professional Point of Sale System' }}</p>
            <p><i class="fas fa-map-marker-alt"></i> {{ config('app.address', app()->getLocale() == 'ar' ? 'العنوان هنا' : 'Address here') }}</p>
            <p><i class="fas fa-phone"></i> {{ config('app.phone', app()->getLocale() == 'ar' ? 'رقم الهاتف هنا' : 'Phone number here') }}</p>
            <p><i class="fas fa-envelope"></i> {{ config('app.email', 'info@example.com') }}</p>
            <p><i class="fas fa-globe"></i> {{ config('app.url', 'www.example.com') }}</p>
        </div>
        
        <div class="receipt-details">
            <p>
                <span><i class="fas fa-receipt"></i> {{ app()->getLocale() == 'ar' ? 'رقم الفاتورة' : 'Invoice Number' }}:</span>
                <span><strong>#{{ $sale->id }}</strong></span>
            </p>
            <p>
                <span><i class="fas fa-calendar-day"></i> {{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}:</span>
                <span>{{ $sale->sale_date }}</span>
            </p>
            <p>
                <span><i class="fas fa-clock"></i> {{ app()->getLocale() == 'ar' ? 'الوقت' : 'Time' }}:</span>
                <span>{{ $sale->created_at->format('H:i:s') }}</span>
            </p>
            <p>
                <span><i class="fas fa-user-tag"></i> {{ app()->getLocale() == 'ar' ? 'العميل' : 'Customer' }}:</span>
                <span>{{ $sale->customer ? $sale->customer->name : (app()->getLocale() == 'ar' ? 'عميل نقدي' : 'Cash Customer') }}</span>
            </p>
            <p>
                <span><i class="fas fa-user-tie"></i> {{ app()->getLocale() == 'ar' ? 'الموظف' : 'Employee' }}:</span>
                <span>{{ $sale->user->name ?? (app()->getLocale() == 'ar' ? 'غير محدد' : 'Not specified') }}</span>
            </p>
            <p>
                <span><i class="fas fa-money-bill-wave"></i> {{ app()->getLocale() == 'ar' ? 'طريقة الدفع' : 'Payment Method' }}:</span>
                <span>
                    @switch($sale->payment_method)
                        @case('cash')
                            <i class="fas fa-coins"></i> {{ app()->getLocale() == 'ar' ? 'نقدي' : 'Cash' }}
                            @break
                        @case('card')
                            <i class="fas fa-credit-card"></i> {{ app()->getLocale() == 'ar' ? 'بطاقة ائتمان' : 'Credit Card' }}
                            @break
                        @case('bank_transfer')
                            <i class="fas fa-university"></i> {{ app()->getLocale() == 'ar' ? 'تحويل بنكي' : 'Bank Transfer' }}
                            @break
                        @default
                            {{ $sale->payment_method }}
                    @endswitch
                </span>
            </p>
            @if(isset($sale->tax_percent) && $sale->tax_percent > 0)
            <p>
                <span><i class="fas fa-percentage"></i> {{ app()->getLocale() == 'ar' ? 'نسبة الضريبة' : 'Tax Rate' }}:</span>
                <span>{{ number_format($sale->tax_percent, 2) }}%</span>
            </p>
            @endif
        </div>
        
        <div class="receipt-items">
            <table>
                <thead>
                    <tr>
                        <th>{{ app()->getLocale() == 'ar' ? 'المنتج' : 'Product' }}</th>
                        <th>{{ app()->getLocale() == 'ar' ? 'الكمية' : 'Quantity' }}</th>
                        <th>{{ app()->getLocale() == 'ar' ? 'السعر' : 'Price' }}</th>
                        <th class="text-end">{{ app()->getLocale() == 'ar' ? 'المجموع' : 'Total' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->saleItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                        <td class="text-end">{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="receipt-total">
            <p>
                <span>{{ app()->getLocale() == 'ar' ? 'المجموع' : 'Subtotal' }}:</span>
                <span>{{ number_format($sale->saleItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
            </p>
            @if($sale->discount > 0)
            <p>
                <span>{{ app()->getLocale() == 'ar' ? 'الخصم' : 'Discount' }}:</span>
                <span>{{ number_format($sale->discount, 2) }}</span>
            </p>
            @endif
            @if($sale->tax > 0)
            <p>
                <span>{{ app()->getLocale() == 'ar' ? 'الضريبة' : 'Tax' }}:</span>
                <span>{{ number_format($sale->tax, 2) }}</span>
            </p>
            @endif
            <p class="total">
                <span>{{ app()->getLocale() == 'ar' ? 'الإجمالي' : 'Total' }}:</span>
                <span>{{ number_format($sale->total_amount, 2) }}</span>
            </p>
        </div>
        
        <div class="barcode">
            <!-- استخدام باركود احترافي -->
            <img src="https://barcodeapi.org/api/code128/{{ $sale->id }}" alt="{{ app()->getLocale() == 'ar' ? 'باركود الفاتورة' : 'Invoice Barcode' }}">
            <p style="font-size: 9pt; margin: 2mm 0 0 0; color: #555;">{{ app()->getLocale() == 'ar' ? 'رقم الفاتورة' : 'Invoice Number' }}: {{ $sale->id }}</p>
        </div>
        
        <!-- إضافة رمز QR -->
        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(config('app.url') . '/pos/receipt/' . $sale->id) }}" alt="{{ app()->getLocale() == 'ar' ? 'رمز QR للفاتورة' : 'Invoice QR Code' }}">
            <p style="font-size: 9pt; margin: 2mm 0 0 0; color: #555;">{{ app()->getLocale() == 'ar' ? 'امسح الرمز لعرض الفاتورة الرقمية' : 'Scan the code to view digital invoice' }}</p>
        </div>
        
        <div class="receipt-footer">
            <p>{{ app()->getLocale() == 'ar' ? 'شكراً لتسوقكم معنا' : 'Thank you for your purchase' }}</p>
            <p>{{ config('app.name') }} &copy; {{ date('Y') }}</p>
        </div>
    </div>
    
    <div class="no-print" style="text-align: center; margin-top: 20px; margin-bottom: 30px;">
        <button onclick="window.print()" style="padding: 12px 25px; background: #009ef7; color: white; border: none; border-radius: 5px; cursor: pointer; font-family: 'Cairo', sans-serif; font-size: 14px; font-weight: 600; box-shadow: 0 2px 5px rgba(0,158,247,0.3); transition: all 0.3s;">
            <i class="fas fa-print" style="{{ app()->getLocale() == 'ar' ? 'margin-right: 8px;' : 'margin-left: 8px;' }}"></i>
            {{ app()->getLocale() == 'ar' ? 'طباعة الفاتورة' : 'Print Invoice' }}
        </button>
        <button onclick="window.location.href='/pos'" style="padding: 12px 25px; background: #50cd89; color: white; border: none; border-radius: 5px; cursor: pointer; font-family: 'Cairo', sans-serif; font-size: 14px; font-weight: 600; box-shadow: 0 2px 5px rgba(80,205,137,0.3); {{ app()->getLocale() == 'ar' ? 'margin-left: 10px;' : 'margin-right: 10px;' }} transition: all 0.3s;">
            <i class="fas fa-shopping-cart" style="{{ app()->getLocale() == 'ar' ? 'margin-right: 8px;' : 'margin-left: 8px;' }}"></i>
            {{ app()->getLocale() == 'ar' ? 'عملية بيع جديدة' : 'New Sale' }}
        </button>
        <button onclick="window.close()" style="padding: 12px 25px; background: #f1416c; color: white; border: none; border-radius: 5px; cursor: pointer; font-family: 'Cairo', sans-serif; font-size: 14px; font-weight: 600; box-shadow: 0 2px 5px rgba(241,65,108,0.3); {{ app()->getLocale() == 'ar' ? 'margin-left: 10px;' : 'margin-right: 10px;' }} transition: all 0.3s;">
            <i class="fas fa-times" style="{{ app()->getLocale() == 'ar' ? 'margin-right: 8px;' : 'margin-left: 8px;' }}"></i>
            {{ app()->getLocale() == 'ar' ? 'إغلاق' : 'Close' }}
        </button>
    </div>
    
    <div class="no-print" style="text-align: center; margin-top: 20px; color: #555; font-size: 12px;">
        <p>{{ app()->getLocale() == 'ar' ? 'تم إنشاء هذه الفاتورة بواسطة نظام' : 'This invoice was generated by' }} {{ config('app.name') }} {{ app()->getLocale() == 'ar' ? 'لنقاط البيع' : 'Point of Sale System' }}</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ app()->getLocale() == 'ar' ? 'جميع الحقوق محفوظة' : 'All rights reserved' }}.</p>
    </div>
    
    <script>
        // طباعة تلقائية عند تحميل الصفحة
        window.onload = function() {
            // تأخير قليل للتأكد من تحميل الصفحة بالكامل
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
