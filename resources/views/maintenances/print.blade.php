<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('maintenances.maintenance_receipt') }}</title>
    <style>
        /* Basic page settings */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .receipt-container {
            width: 320px;
            padding: 20px;
            border: 2px solid #00796b;
            background-color: #e0f7fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            position: relative;
            text-align: left;
        }

        /* Title styling */
        h1 {
            text-align: center;
            font-size: 18px;
            color: #00796b;
            border-bottom: 1px dashed #00796b;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        /* Barcode styling */
        .barcode-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .barcode img {
            width: 80%;
            height: auto;
        }

        .barcode-number {
            font-size: 12px;
            color: #333;
            font-weight: bold;
            text-align: center;
            margin-top: 5px;
        }

        /* Info section styling */
        .info-section p {
            margin: 5px 0;
            padding: 5px;
        }

        .info-label {
            font-weight: bold;
            color: #00796b;
            width: 90px;
            display: inline-block;
        }

        /* Footer note styling */
        .footer-note {
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
            color: #555;
            border-top: 1px dashed #00796b;
            padding-top: 10px;
        }
    </style>
</head>
<body>
<div class="receipt-container">
    <!-- Barcode at the top -->
    <div class="barcode-section">
        <img src="data:image/png;base64,{{ $barcodeImage }}" alt="Barcode">
        <p class="barcode-number">{{ $barcodeNumber }}</p>
    </div>

    <!-- Title -->
    <h1>{{ __('maintenances.maintenance_department') }}</h1>

    <!-- Maintenance Information -->
    <div class="info-section">
        <p><span class="info-label">{{ __('maintenances.customer_name') }}:</span> {{ $maintenance->customer_name }}</p>
        <p><span class="info-label">{{ __('maintenances.phone_number') }}:</span> {{ $maintenance->phone_number }}</p>
        <p><span class="info-label">{{ __('maintenances.device_type') }}:</span> {{ $maintenance->device_type }}</p>
        <p><span class="info-label">{{ __('maintenances.issue') }}:</span> {{ $maintenance->problem_description }}</p>
        <p><span class="info-label">{{ __('maintenances.cost') }}:</span> {{ $maintenance->cost ?? __('maintenances.not_specified') }}</p>
        <p><span class="info-label">{{ __('maintenances.password') }}:</span> {{ $maintenance->password ?? __('maintenances.not_available') }}</p>
        <p><span class="info-label">{{ __('maintenances.maintenance_date') }}:</span> {{ $maintenance->created_at->format('d/m/Y') }}</p>
        <p><span class="info-label">{{ __('maintenances.time') }}:</span> {{ $maintenance->created_at->format('H:i A') }}</p>
    </div>

    <!-- Footer note -->
    <p class="footer-note">
        {{ __('maintenances.after_delivering_the_device') }}
        <br>
        {{ __('maintenances.maintenance_parts_warranty') }}
    </p>
</div>

<script>
    window.print();
</script>
</body>
</html>
