@extends('layouts.app')

@section('title', '- ' . __('Phone Details'))

@section('content')
    <div class="container">
        <h1>بيانات الجهاز</h1>

        @if($device->name)<p><strong>اسم الجهاز:</strong> {{ $device->name ?? 'غير محدد' }}</p>@endif
        @if($device->color)<p><strong>اللون:</strong> {{ $device->color ?? 'غير محدد' }}</p>@endif
        @if($device->battery)<p><strong>حالة البطارية:</strong> {{ $device->battery ?? 'غير محددة' }}%</p>@endif
        @if($device->storage)<p><strong>السعة التخزينية:</strong> {{ $device->storage ?? 'غير محددة' }} GB</p>@endif
        @if($device->condition)<p><strong>الحالة:</strong> {{ $device->condition ?? 'غير محددة' }}</p>@endif
        @if($device->imei)<p><strong>IMEI:</strong> {{ $device->imei ?? 'غير محدد' }}</p>@endif
        @if($device->price)<p><strong>السعر:</strong> ${{ $device->price ?? 'غير محدد' }}</p>@endif

        <h3>QR Code</h3>
        <img src="{{ $qrCodeDataUri }}" alt="QR Code">

        <button onclick="printQrCode()" class="btn btn-secondary mt-3">طباعة QR Code</button>
    </div>

    <script>
        function printQrCode() {
            var printWindow = window.open('', '', 'width=400,height=400');
            var qrCodeElement = document.querySelector('img[alt="QR Code"]').outerHTML;

            printWindow.document.write('<html><head><title>طباعة QR Code</title>');
            printWindow.document.write('<style>body{text-align: center; margin: 0; padding: 0;} img{ width: 100%; height: auto; }</style></head><body>');
            printWindow.document.write(qrCodeElement);
            printWindow.document.write('</body></html>');

            printWindow.document.close();
            printWindow.print();
        }
    </script>
@endsection
