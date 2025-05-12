<?php

namespace App\Observers;

use App\Models\MobileDetail;
use App\Models\Product; // Needed to access the related product
use App\Http\Controllers\ProductController; // To access QR generation logic
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MobileDetailObserver
{
    /**
     * Handle the MobileDetail "created" event.
     */
    public function created(MobileDetail $mobileDetail): void
    {
        // QR code should be generated when mobile details are first created.
        // This is already handled in ProductController's storeMobileDetails method via dispatching a job.
        // If not, this would be a place to trigger it.
        // Log::info("MobileDetailObserver: MobileDetail created for product ID {$mobileDetail->product_id}. Triggering initial QR generation.");
        // $this->triggerQrCodeGeneration($mobileDetail);
    }

    /**
     * Handle the MobileDetail "updated" event.
     */
    public function updated(MobileDetail $mobileDetail): void
    {
        // Define which MobileDetail fields, if changed, should trigger a QR update.
        // Exclude 'qrcode' itself from triggering an update to avoid loops.
        $relevantFields = [
            'color', 'storage', 'battery_health', 'ram', 'gpu', 'cpu',
            'condition', 'device_description', 'has_box',
            'scan_id', 'scan_documents'
        ];
        
        $changedFields = $mobileDetail->getChanges();
        $shouldUpdateQR = false;

        foreach ($relevantFields as $field) {
            if (array_key_exists($field, $changedFields)) {
                $shouldUpdateQR = true;
                break;
            }
        }

        if ($shouldUpdateQR) {
            Log::info("MobileDetailObserver: Relevant field updated for MobileDetail ID {$mobileDetail->id}. Triggering QR update.");
            $this->triggerQrCodeGeneration($mobileDetail);
        }
    }

    /**
     * Handle the MobileDetail "deleted" event.
     */
    public function deleted(MobileDetail $mobileDetail): void
    {
        // If a mobile detail record is deleted, delete its associated QR code file.
        if ($mobileDetail->qrcode && Storage::disk('public')->exists($mobileDetail->qrcode)) {
            Storage::disk('public')->delete($mobileDetail->qrcode);
            Log::info("MobileDetailObserver: Deleted QR code file {$mobileDetail->qrcode} for deleted MobileDetail ID {$mobileDetail->id}.");
        }
    }

    /**
     * Helper function to trigger QR code generation for a mobile detail.
     */
    protected function triggerQrCodeGeneration(MobileDetail $mobileDetail): void
    {
        $product = $mobileDetail->product; // Get the associated product
        if (!$product) {
            Log::error("MobileDetailObserver: Product not found for MobileDetail ID {$mobileDetail->id} during QR trigger.");
            return;
        }

        Log::info("MobileDetailObserver: Dispatching UpdateDeviceQrCodeJob for MobileDetail ID: {$mobileDetail->id} from MobileDetailObserver.");
        \App\Jobs\UpdateDeviceQrCodeJob::dispatch($mobileDetail, $product)->afterResponse();
    }
}
