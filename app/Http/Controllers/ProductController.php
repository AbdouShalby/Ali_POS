<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Debt;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MobileDetail; // Added this line
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage products');
    }

    public function index(Request $request)
    {
        $products = Product::filter($request->only([
            'search', 'category', 'brand', 'min_price', 'max_price', 'barcode', 'selling_price'
        ]))->orderBy('created_at', 'desc')->paginate(10);

        return view('products.index', [
            'products' => $products,
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'search' => $request->get('search'),
        ])->with('activePage', 'products');
    }

    public function create()
    {
        return view('products.create', [
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'warehouses' => Warehouse::all()
        ])->with('activePage', 'products.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'is_mobile' => $request->has('is_mobile') ? true : false,
        ]);

        $validated = $this->validateProduct($request);
        
        // Validate price-cost relationship
        if ($request->input('price') < $request->input('cost')) {
            Log::warning("Product price is less than cost: " . $request->input('name'));
        }
        
        // Validate barcode format
        if (!$this->validateBarcode($request->input('barcode'))) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['barcode' => 'Invalid barcode format. Must be 8-13 digits.']);
        }

        $uploadedImagePaths = $this->storeFiles($request); // Now returns only path for 'image' if uploaded

        // Prepare data for Product creation, excluding fields that were removed or moved
        $productData = $validated; // Start with validated data (name, barcode, cost, etc.)
        if (!empty($uploadedImagePaths['image'])) {
            $productData['image'] = $uploadedImagePaths['image'];
        }

        // Remove fields from $validated that are not direct properties of Product model anymore
        // or are handled separately (like warehouses, or mobile-specific details)
        // Example: $validated might still contain 'warehouses' array from form, but it's handled by attachWarehouses
        // Ensure $productData only contains fields present in Product::$fillable
        $productFillable = (new Product)->getFillable();
        $productDataForCreate = array_intersect_key($productData, array_flip($productFillable));
        $productDataForCreate['is_mobile'] = $request->boolean('is_mobile'); // Ensure is_mobile is set correctly

        $product = Product::create($productDataForCreate);

        // --- DEBT CREATION LOGIC (Commented Out) ---
        // This section needs to be re-evaluated based on new purchase/debt management flow.

        // Attach warehouses if data is provided in the request
        if (isset($validated['warehouses']) && is_array($validated['warehouses'])) {
            $this->attachWarehouses($product, $validated['warehouses']);
        }

        if ($product->is_mobile) {
            $this->storeMobileDetails($product, $request); // This will handle QR for device
        }

        return redirect()->route('products.index')
            ->with('success', __('products.product_added_successfully', ['name' => $product->name]));
    }

    protected function validateProduct(Request $request, Product $product = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'barcode' => [
                'required',
                'string',
                'max:255',
                $product ? 'unique:products,barcode,' . $product->id : 'unique:products,barcode',
            ],
            'cost' => 'required|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'wholesale_price' => 'nullable|numeric|min:0',
            'min_sale_price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id', // Optional, as per migration changes
            'brand_id' => 'nullable|exists:brands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
            'is_mobile' => 'nullable|boolean',

            // Rules for warehouses if they are submitted with the main product form
            // This assumes 'warehouses' is an array of objects, each with id, stock, and stock_alert
            'warehouses' => 'nullable|array',
            'warehouses.*.id' => 'required_with:warehouses|exists:warehouses,id',
            'warehouses.*.stock' => 'required_with:warehouses|numeric|min:0',
            'warehouses.*.stock_alert' => 'required_with:warehouses|numeric|min:0',
            
            // These fields are no longer part of the Product model directly.
        ];

        return $request->validate($rules);
    }

    protected function storeFiles(Request $request)
    {
        $uploadedFilesPaths = [];
        
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $processedImage = $this->processImage($imageFile);
            $uploadedFilesPaths['image'] = $processedImage->store('products/images', 'public');
        }
        
        // scan_id and scan_documents are now handled in storeMobileDetails
        return $uploadedFilesPaths;
    }

    protected function attachWarehouses($product, $warehouses)
    {
        $currentWarehouseIds = $product->warehouses->pluck('id')->toArray();

        $newWarehouseIds = collect($warehouses)->pluck('id')->toArray();

        $warehousesToDetach = array_diff($currentWarehouseIds, $newWarehouseIds);

        if (!empty($warehousesToDetach)) {
            $product->warehouses()->detach($warehousesToDetach);
        }

        foreach ($warehouses as $warehouse) {
            if ($product->warehouses()->where('warehouse_id', $warehouse['id'])->exists()) {
                $product->warehouses()->updateExistingPivot($warehouse['id'], [
                    'stock' => $warehouse['stock'],
                    'stock_alert' => $warehouse['stock_alert'],
                ]);
            } else {
                $product->warehouses()->attach($warehouse['id'], [
                    'stock' => $warehouse['stock'],
                    'stock_alert' => $warehouse['stock_alert'],
                ]);
            }
        }
    }

    protected function storeMobileDetails(Product $product, Request $request)
    {
        try {
            $rules = [
                'color' => 'nullable|string|max:255',
                'storage' => 'nullable|string|max:255',
                'battery_health' => 'nullable|numeric|min:0|max:100',
                'ram' => 'nullable|string|max:255',
                'gpu' => 'nullable|string|max:255',
                'cpu' => 'nullable|string|max:255',
                'condition' => 'nullable|string|max:255',
                'device_description' => 'nullable|string',
                'has_box' => 'nullable|boolean',
                'scan_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'scan_documents' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,pdf|max:4096',
            ];

            $validatedMobileData = $request->validate($rules);
            $validatedMobileData['has_box'] = $request->boolean('has_box');

            if ($request->hasFile('scan_id')) {
                $processedScanId = $this->processImage($request->file('scan_id'));
                $validatedMobileData['scan_id'] = $processedScanId->store('mobiles/scan_ids', 'public');
            } elseif ($request->filled('existing_scan_id')){
                $validatedMobileData['scan_id'] = $request->input('existing_scan_id');
            } else if (!$request->hasFile('scan_id') && !$request->filled('existing_scan_id')){
                // If no new file and no existing file path, old value might be cleared if not handled carefully.
                // To preserve old value if no new file and no existing path, explicitly load old path.
                if ($product->mobileDetail && $product->mobileDetail->scan_id && !$request->boolean('remove_scan_id')) { // Assuming a remove_scan_id flag from form
                     $validatedMobileData['scan_id'] = $product->mobileDetail->scan_id;
                } else {
                     $validatedMobileData['scan_id'] = null; // Explicitly set to null if to be removed or no new/existing
                }
            }

            if ($request->hasFile('scan_documents')) {
                $processedScanDocs = $this->processImage($request->file('scan_documents'));
                $validatedMobileData['scan_documents'] = $processedScanDocs->store('mobiles/scan_documents', 'public');
            } elseif ($request->filled('existing_scan_documents')) {
                $validatedMobileData['scan_documents'] = $request->input('existing_scan_documents');
            } else if (!$request->hasFile('scan_documents') && !$request->filled('existing_scan_documents')){
                if ($product->mobileDetail && $product->mobileDetail->scan_documents && !$request->boolean('remove_scan_documents')) { // Assuming a remove_scan_documents flag
                     $validatedMobileData['scan_documents'] = $product->mobileDetail->scan_documents;
                } else {
                    $validatedMobileData['scan_documents'] = null;
                }
            }

            $mobileDetail = $product->mobileDetail()->updateOrCreate(
                ['product_id' => $product->id],
                $validatedMobileData
            );

            // Generate or update QR Code for the mobile detail
            if ($mobileDetail) {
                // Dispatch QR code generation to a background job
                \App\Jobs\UpdateDeviceQrCodeJob::dispatch($mobileDetail, $product)->afterResponse();
                Log::info("Dispatched UpdateDeviceQrCodeJob from storeMobileDetails for MobileDetail ID: {$mobileDetail->id}");
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors specifically for debugging if needed
            Log::error('Validation Error in storeMobileDetails: ' . $e->getMessage(), $e->errors());
            throw $e; // Re-throw to let Laravel handle it (e.g., redirect back with errors)
        } catch (\Exception $e) {
            Log::error('Error in storeMobileDetails: ' . $e->getMessage());
            throw $e; // Re-throw for general error handling
        }
    }

    /**
     * Prepares the data array for QR code generation for a device.
     * @param MobileDetail $mobileDetail The mobile detail object.
     * @param Product $product The associated product object.
     * @return array The data to be encoded in the QR code.
     */
    protected function prepareDeviceQRData(MobileDetail $mobileDetail, Product $product): array
    {
        $qrData = [];

        // Basic product info
        if ($product->name) {
            $qrData['Product Name'] = $product->name;
        }
        if ($product->price) {
            $qrData['Price'] = $product->price; // Assuming price is relevant for the QR
        }
        if ($product->barcode) {
            $qrData['Barcode'] = $product->barcode;
        }

        // Device-specific details from MobileDetail model
        $deviceFields = [
            'color' => 'Color',
            'storage' => 'Storage',
            'battery_health' => 'Battery Health',
            'ram' => 'RAM',
            'cpu' => 'CPU',
            'gpu' => 'GPU',
            'condition' => 'Condition',
            // 'imei' was removed
        ];

        foreach ($deviceFields as $field => $label) {
            if (!empty($mobileDetail->$field)) {
                $qrData[$label] = ($field === 'battery_health' && is_numeric($mobileDetail->$field))
                    ? $mobileDetail->$field . '%'
                    : $mobileDetail->$field;
            }
        }
        
        if ($mobileDetail->has_box) {
            $qrData['Box Included'] = 'Yes';
        }

        // Add more fields from $mobileDetail or $product as needed for the QR code
        // For example, $mobileDetail->device_description if it's short enough

        return $qrData;
    }

    /**
     * Generates or updates a QR Code for a given mobile device detail and saves it.
     * @param MobileDetail $mobileDetail The mobile detail object to update with QR code path.
     * @param Product $product The associated product object.
     */
    protected function generateOrUpdateDeviceQRCode(MobileDetail $mobileDetail, Product $product)
    {
        $qrData = $this->prepareDeviceQRData($mobileDetail, $product);

        if (empty($qrData)) {
            Log::warning("QR Data is empty for mobile detail ID: {$mobileDetail->id}. Unable to generate QR Code.");
            // Optionally, clear any existing QR code if data is now empty
            if ($mobileDetail->qrcode) {
                Storage::disk('public')->delete($mobileDetail->qrcode);
                $mobileDetail->qrcode = null;
                $mobileDetail->save();
            }
            return;
        }

        try {
            $qrContent = implode("\n", array_map(fn($key, $value) => "$key: $value", array_keys($qrData), $qrData));
            $qrContent = mb_convert_encoding($qrContent, 'UTF-8', 'auto');

            $qrCodeDirectory = 'qrcodes/devices'; // Store device QR codes in a sub-directory
            $fileName = $qrCodeDirectory . '/' . $mobileDetail->id . '_' . uniqid() . '.png';

            // Ensure the directory exists
            Storage::disk('public')->makeDirectory($qrCodeDirectory);
            
            // Generate QR code image content
            $qrImageContent = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                ->encoding('UTF-8')
                ->size(300) // Standard QR size
                ->generate($qrContent);

            // Store the new QR code
            Storage::disk('public')->put($fileName, $qrImageContent);

            // Delete old QR code if it exists and is different
            if ($mobileDetail->qrcode && $mobileDetail->qrcode !== $fileName && Storage::disk('public')->exists($mobileDetail->qrcode)) {
                Storage::disk('public')->delete($mobileDetail->qrcode);
            }

            // Update the mobileDetail with the new QR code path
            $mobileDetail->qrcode = $fileName;
            $mobileDetail->save();

            Log::info("Device QR Code generated/updated and saved to: " . $fileName . " for MobileDetail ID: " . $mobileDetail->id);

        } catch (\Exception $e) {
            Log::error("Failed to generate/update Device QR Code for MobileDetail ID: {$mobileDetail->id}: " . $e->getMessage());
            // Do not throw exception here to prevent breaking the main flow if QR generation fails in background
        }
    }


    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'mobileDetail', 'warehouses']);
        
        // Debt logic is commented out in store/update, so this might not be relevant anymore
        // or needs to be re-evaluated based on how debts are linked.
        $debts = Debt::where('product_id', $product->id)->get(); 
        
        return view('products.show', compact('product', 'debts'));
    }

    public function edit($id)
    {
        return view('products.edit', [
            'product' => Product::with(['mobileDetail', 'warehouses'])->findOrFail($id),
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'warehouses' => Warehouse::all(),
        ])->with('activePage', 'products');
    }

    public function update(Request $request, Product $product)
    {
        $request->merge([
            'is_mobile' => $request->has('is_mobile') ? true : false,
        ]);

        $validatedProductData = $this->validateProduct($request, $product);

        // Prepare data for Product update
        $productDataToUpdate = $validatedProductData;

        // Handle product image update
        if ($request->hasFile('image')) {
            // Optionally delete old image if it exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $productDataToUpdate['image'] = $request->file('image')->store('products/images', 'public');
        } elseif ($request->filled('remove_image') && $request->input('remove_image') == '1') {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $productDataToUpdate['image'] = null;
        }

        // scan_id and scan_documents are handled by storeMobileDetails

        // Filter to only include fillable fields for the Product model
        $productFillable = (new Product)->getFillable();
        $productDataForUpdate = array_intersect_key($productDataToUpdate, array_flip($productFillable));
        $productDataForUpdate['is_mobile'] = $request->boolean('is_mobile'); // Ensure is_mobile is set correctly

        $product->update($productDataForUpdate);

        // Attach/update warehouses if data is provided
        if (isset($validatedProductData['warehouses']) && is_array($validatedProductData['warehouses'])) {
            $this->attachWarehouses($product, $validatedProductData['warehouses']);
        }

        if ($product->is_mobile) {
            $this->storeMobileDetails($product, $request); // This will handle mobile details and device QR code
        } else {
            // If the product is no longer a mobile, delete its mobile details and associated QR code file
            if ($product->mobileDetail) {
                if ($product->mobileDetail->qrcode && Storage::disk('public')->exists($product->mobileDetail->qrcode)) {
                    Storage::disk('public')->delete($product->mobileDetail->qrcode);
                }
                $product->mobileDetail()->delete();
            }
        }

        return redirect()->route('products.index')->with('success', __('products.product_updated_successfully', ['name' => $product->name]));
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('products.index')->with('success', __('The Product Has Been Deleted Successfully.'));
    }

    public function generateBarcode()
    {
        do {
            $barcode = mt_rand(1000000000000, 9999999999999);
        } while (Product::where('barcode', $barcode)->exists());

        return response()->json(['success' => true, 'barcode' => $barcode], 200, ['Content-Type' => 'application/json']);
    }

    public function deleteImage(Request $request, Product $product)
    {
        $imageType = $request->input('image_type'); // e.g., 'image', 'scan_id', 'scan_documents'
        $targetModel = $product;
        $columnToUpdate = null;

        if ($imageType === 'image') {
            $columnToUpdate = 'image';
        } elseif ($imageType === 'scan_id' || $imageType === 'scan_documents') {
            if (!$product->is_mobile || !$product->mobileDetail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Device details not found for this product.',
                ], 404);
            }
            $targetModel = $product->mobileDetail;
            $columnToUpdate = $imageType; // 'scan_id' or 'scan_documents' are direct columns on mobileDetail
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid image type specified.',
            ], 400);
        }

        if ($targetModel && $columnToUpdate && $targetModel->$columnToUpdate) {
            Storage::disk('public')->delete($targetModel->$columnToUpdate);
            $targetModel->$columnToUpdate = null;
            $targetModel->save();

            // If a device's QR code image itself is being deleted (if image_type was 'qrcode_device'),
            // this logic would be slightly different, but qrcode is a path, not an uploaded file typically deleted this way.
            // However, if scan_id or scan_documents change, the QR code for the device might need an update.
            // This can be triggered explicitly or via an event listener on MobileDetail update.
            // For simplicity here, we are just deleting the specified image.
            // If deleting scan_id or scan_documents should regenerate QR, that logic needs to be added.
            // Consider calling $this->generateOrUpdateDeviceQRCode($product->mobileDetail, $product) if applicable and imageType is scan_id/scan_documents

            return response()->json([
                'success' => true,
                'message' => ucfirst(str_replace('_', ' ', $imageType)) . ' deleted successfully.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => ucfirst(str_replace('_', ' ', $imageType)) . ' not found or already deleted.',
        ], 404);
    }

    public function removeWarehouse($productId, $warehouseId)
    {
        $product = Product::findOrFail($productId);

        if ($product->warehouses()->where('warehouse_id', $warehouseId)->exists()) {
            $product->warehouses()->detach($warehouseId);

            return response()->json([
                'success' => true,
                'message' => __('Warehouse removed successfully.'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Warehouse not found.'),
        ]);
    }

    public function searchProducts(Request $request)
    {
        try {
            $term = $request->input('term');
            
            if (!$term || strlen($term) < 2) {
                return response()->json([]);
            }
            
            $products = Product::where('name', 'LIKE', "%{$term}%")
                ->orWhere('barcode', 'LIKE', "%{$term}%")
                ->select('id', 'name', 'barcode', 'price', 'cost') // Ensure these fields are sufficient for display
                ->limit(10)
                ->get();
                
            return response()->json($products);

        } catch (\Exception $e) {
            Log::error("Error in searchProducts: " . $e->getMessage());
            // Return a JSON error response that the frontend can understand
            return response()->json(['error' => true, 'message' => 'An error occurred while searching products.'], 500);
        }
    }

    public function duplicateProduct($id)
    {
        $product = Product::with('mobileDetail')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'product' => $product,
            'mobile_details' => $product->mobileDetail
        ]);
    }

    protected function validateBarcode($barcode)
    {
        // Check if it's a valid EAN-13, EAN-8, UPC-A, or UPC-E format
        return preg_match('/^[0-9]{8,13}$/', $barcode);
    }

    public function checkBarcode(Request $request, $barcode)
    {
        // Additional barcode format validation
        $isValidFormat = $this->validateBarcode($barcode);
        
        if (!$isValidFormat) {
            return response()->json([
                'exists' => false,
                'valid_format' => false,
                'message' => 'Invalid barcode format'
            ]);
        }
        
        // Check if barcode exists (excluding current product if provided)
        $productId = $request->input('product_id');
        $query = Product::where('barcode', $barcode);

        if ($productId) {
            $query->where('id', '!=', $productId);
        }

        $exists = $query->exists();

        return response()->json([
            'exists' => $exists,
            'valid_format' => true,
            'message' => $exists ? 'Barcode already exists' : 'Barcode is available'
        ]);
    }

    protected function processImage($image)
    {
        // Since we don't have access to image manipulation libraries,
        // we'll just store the original file
        try {
            return $image;
        } catch (\Exception $e) {
            \Log::error("Image processing issue: " . $e->getMessage());
            return $image;
        }
    }

}
