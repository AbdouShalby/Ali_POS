<?php

namespace App\Jobs;

use App\Models\MobileDetail;
use App\Models\Product;
use App\Http\Controllers\ProductController; // Or a dedicated QR Code Service
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateDeviceQrCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected MobileDetail $mobileDetail;
    protected Product $product;

    /**
     * Create a new job instance.
     */
    public function __construct(MobileDetail $mobileDetail, Product $product)
    {
        $this->mobileDetail = $mobileDetail;
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("UpdateDeviceQrCodeJob: Processing QR code for MobileDetail ID: {$this->mobileDetail->id}");
        try {
            // Resolve ProductController or ideally a dedicated service for QR generation
            $productController = app(ProductController::class);
            
            // Call the public method that internally calls the protected QR generation logic
            // This assumes generateOrUpdateDeviceQRCodePublic is correctly implemented in ProductController
            $productController->generateOrUpdateDeviceQRCodePublic($this->mobileDetail, $this->product);
            
            Log::info("UpdateDeviceQrCodeJob: Successfully processed QR code for MobileDetail ID: {$this->mobileDetail->id}");
        } catch (\Exception $e) {
            Log::error("UpdateDeviceQrCodeJob: Failed to process QR code for MobileDetail ID: {$this->mobileDetail->id}. Error: " . $e->getMessage());
            // Optionally, rethrow or handle specific exceptions if needed for retry logic etc.
        }
    }
}
