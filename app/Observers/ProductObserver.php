<?php

namespace App\Observers;

use App\Models\Product;
use App\Http\Controllers\ProductController; // To access QR generation logic
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // Check if the product is a mobile device and has mobile details
        if ($product->is_mobile && $product->mobileDetail) {
            // Define which product fields, if changed, should trigger a QR update for the device
            $relevantFields = ['name', 'price', 'barcode']; // Add other fields if they are part of QR data
            $changedFields = $product->getChanges();

            $shouldUpdateQR = false;
            foreach ($relevantFields as $field) {
                if (array_key_exists($field, $changedFields)) {
                    $shouldUpdateQR = true;
                    break;
                }
            }

            if ($shouldUpdateQR) {
                Log::info("ProductObserver: Relevant field updated for product ID {$product->id}. Triggering QR update for MobileDetail ID {$product->mobileDetail->id}.");
                // We need an instance of ProductController or a dedicated service to call the QR generation method.
                // For simplicity, let's assume ProductController has a public static method or a helper can be used.
                // This is a bit of a shortcut; a dedicated service or event/listener might be cleaner.
                // We will call a method on an instance of ProductController for now.
                // Note: This assumes ProductController and its methods are appropriately set up.
                // The QR generation is already dispatched to a job from ProductController, 
                // so we might just need to ensure the data passed to that job is fresh.
                // Or, we can re-dispatch the job here.
                
                // Re-dispatching the job as done in storeMobileDetails seems appropriate
                // to ensure consistency and background processing.
                $controller = app(ProductController::class); // Resolve controller instance
                
                // Ensure that generateOrUpdateDeviceQRCode is public or callable this way,
                // or refactor QR generation to a dedicated service.
                // For now, assuming it can be called (might need to make it public if it's protected).
                // A better approach: dispatch a dedicated job for QR regeneration.

                // Dispatching the job to handle QR code update
                $mobileDetail = $product->mobileDetail;
                Log::info("ProductObserver: Dispatching UpdateDeviceQrCodeJob for MobileDetail ID: {$mobileDetail->id} due to Product update.");
                \App\Jobs\UpdateDeviceQrCodeJob::dispatch($mobileDetail, $product)->afterResponse();
            }
        }
    }

    // We might also need `deleted` if product deletion should affect something related to QR or MobileDetail files
    // public function deleted(Product $product): void
    // {
    //     if ($product->is_mobile && $product->mobileDetail) {
    //         // Logic to delete QR file if product is deleted and it was a device
    //         // This is already handled in ProductController update (when is_mobile becomes false) 
    //         // and by onDelete(cascade) for mobile_details table.
    //         // However, explicit file deletion for QR from MobileDetail could be added here for robustness.
    //     }
    // }
}
