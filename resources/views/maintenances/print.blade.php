<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Maintenance Receipt') }}</title>
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
    <h1>{{ __('Maintenance Department') }}</h1>

    <!-- Maintenance Information -->
    <div class="info-section">
        <p><span class="info-label">{{ __('Customer Name') }}:</span> {{ $maintenance->customer_name }}</p>
        <p><span class="info-label">{{ __('Phone Number') }}:</span> {{ $maintenance->phone_number }}</p>
        <p><span class="info-label">{{ __('Device Type') }}:</span> {{ $maintenance->device_type }}</p>
        <p><span class="info-label">{{ __('Issue') }}:</span> {{ $maintenance->problem_description }}</p>
        <p><span class="info-label">{{ __('Cost') }}:</span> {{ $maintenance->cost ?? __('Not specified') }}</p>
        <p><span class="info-label">{{ __('Password') }}:</span> {{ $maintenance->password ?? __('Not available') }}</p>
        <p><span class="info-label">{{ __('Maintenance Date') }}:</span> {{ $maintenance->created_at->format('d/m/Y') }}</p>
        <p><span class="info-label">{{ __('Time') }}:</span> {{ $maintenance->created_at->format('H:i A') }}</p>
    </div>

    <!-- Footer note -->
    <p class="footer-note">
        {{ __('After delivering the device to the maintenance department, please follow up within 15 days.') }}
        <br>
        {{ __('Maintenance parts warranty is 3 days - Please bring the receipt when collecting.') }}
    </p>
</div>

<script>
    window.print();
</script>
</body>
</html>
