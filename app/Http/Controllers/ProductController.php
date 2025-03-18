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
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            'suppliers' => Supplier::all(),
            'customers' => Customer::all(),
            'warehouses' => Warehouse::all()
        ])->with('activePage', 'products.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'is_mobile' => $request->has('is_mobile') ? true : false,
        ]);

        $validated = $this->validateProduct($request);

        $files = $this->storeFiles($request);

        $productData = array_merge($validated, $files, [
            'client_type' => $request->payment_method === 'credit' ? 'supplier' : $request->client_type,
            'customer_id' => $request->payment_method === 'credit' ? null : ($request->client_type === 'customer' ? $request->customer_id : null),
            'supplier_id' => $request->payment_method === 'credit' ? $request->supplier_id : ($request->client_type === 'supplier' ? $request->supplier_id : null),
            'payment_method' => $request->payment_method,
            'seller_name' => $request->seller_name ?? auth()->user()->name,
        ]);

        $product = Product::create($productData);

        if ($request->payment_method === 'credit') {
            Debt::create([
                'supplier_id' => $request->supplier_id,
                'product_id' => $product->id,
                'amount' => $request->price,
                'note' => 'Debt created for product: ' . $product->name,
            ]);
        }

        $this->attachWarehouses($product, $validated['warehouses']);

        if ($request->is_mobile) {
            $this->storeMobileDetails($product, $request);
        }

        $this->generateQRCode($product);

        return redirect()->route('products.index')->with('success', __('products.product_added_successfully', ['name' => $product->name]));
    }

    protected function validateProduct($request, $product = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'barcode' => [
                'required',
                'string',
                'max:255',
                $product ? 'unique:products,barcode,' . $product->id : 'unique:products,barcode',
            ],
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'warehouses.*.id' => 'required|exists:warehouses,id',
            'warehouses.*.stock' => 'required|numeric|min:0',
            'warehouses.*.stock_alert' => 'required|numeric|min:0',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'wholesale_price' => 'required|numeric',
            'min_sale_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
            'client_type' => 'nullable|in:customer,supplier',
            'customer_id' => 'nullable|required_if:client_type,customer|exists:customers,id',
            'supplier_id' => 'nullable|required_if:client_type,supplier|exists:suppliers,id',
            'payment_method' => 'nullable|string|in:cash,credit',
            'is_mobile' => 'nullable|boolean',
        ];

        return $request->validate($rules);
    }

    protected function storeFiles($request)
    {
        return [
            'image' => $request->hasFile('image') ? $request->file('image')->store('products/images', 'public') : null,
            'scan_id' => $request->hasFile('scan_id') ? $request->file('scan_id')->store('products/scan_ids', 'public') : null,
            'scan_documents' => $request->hasFile('scan_documents') ? $request->file('scan_documents')->store('products/scan_documents', 'public') : null,
        ];
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

    protected function storeMobileDetails($product, $request)
    {
        try {
            $rules = [
                'color' => 'nullable|string|max:255',
                'imei' => 'nullable|string|max:255',
                'storage' => 'nullable|string|max:255',
                'battery_health' => 'nullable|numeric|min:0|max:100',
                'ram' => 'nullable|string|max:255',
                'gpu' => 'nullable|string|max:255',
                'cpu' => 'nullable|string|max:255',
                'condition' => 'nullable|string|max:255',
                'device_description' => 'nullable|string',
                'has_box' => 'nullable|boolean',
            ];

            $validated = $request->validate($rules);

            $product->mobileDetail()->updateOrCreate(
                ['product_id' => $product->id],
                $validated
            );
        } catch (\Exception $e) {
            dd('Error in storeMobileDetails: ' . $e->getMessage());
        }
    }

    protected function generateQRCode($product)
    {
        $qrData = $this->prepareQRData($product);

        if (!empty($qrData)) {
            try {
                $qrContent = implode("\n", array_map(fn($key, $value) => "$key: $value", array_keys($qrData), $qrData));

                $qrContent = mb_convert_encoding($qrContent, 'UTF-8', 'auto');

                $qrCodePath = public_path('qrcodes');
                if (!file_exists($qrCodePath)) {
                    mkdir($qrCodePath, 0755, true);
                }

                $fileName = 'qrcodes/' . uniqid() . '.png';

                \QrCode::format('png')
                    ->encoding('UTF-8')
                    ->size(300)
                    ->generate($qrContent, public_path($fileName));

                $product->qrcode = $fileName;
                $product->save();

                \Log::info("QR Code generated and saved to: " . public_path($fileName));
            } catch (\Exception $e) {
                \Log::error("Failed to generate QR Code: " . $e->getMessage());
                throw new \Exception('Failed to generate QR Code. Please check the logs for more details.');
            }
        } else {
            \Log::warning("QR Data is empty. Unable to generate QR Code.");
        }
    }

    protected function prepareQRData($product)
    {
        $qrData = [];

        $fields = [
            'name' => 'Name',
            'price' => 'Price',
        ];

        foreach ($fields as $field => $label) {
            if ($product->$field) {
                $qrData[$label] = $product->$field;
            }
        }

        if ($product->is_mobile && $product->mobileDetail) {
            $mobileDetails = $product->mobileDetail;

            $mobileFields = [
                'color' => 'Color',
                'battery_health' => 'Battery Health',
                'ram' => 'RAM',
                'cpu' => 'CPU',
                'gpu' => 'GPU',
                'condition' => 'Condition',
                'imei' => 'IMEI',
            ];

            foreach ($mobileFields as $field => $label) {
                if ($mobileDetails->$field) {
                    $qrData[$label] = $field === 'battery_health'
                        ? $mobileDetails->$field . '%'
                        : $mobileDetails->$field;
                }
            }
        }

        return $qrData;
    }

    public function show(Product $product)
    {
        return view('products.show', [
            'product' => $product->load(['category', 'brand', 'mobileDetail', 'warehouses'])
        ])->with('activePage', 'products');
    }

    public function edit($id)
    {
        return view('products.edit', [
            'product' => Product::with(['mobileDetail', 'warehouses'])->findOrFail($id),
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'suppliers' => Supplier::all(),
            'customers' => Customer::all(),
            'warehouses' => Warehouse::all(),
        ])->with('activePage', 'products');
    }

    public function update(Request $request, Product $product)
    {
        $request->merge([
            'is_mobile' => $request->has('is_mobile') ? true : false,
        ]);

        $validated = $this->validateProduct($request, $product);

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products/images', 'public');
        }

        if ($request->hasFile('scan_id')) {
            $product->scan_id = $request->file('scan_id')->store('products/scan_ids', 'public');
        }

        if ($request->hasFile('scan_documents')) {
            $product->scan_documents = $request->file('scan_documents')->store('products/scan_documents', 'public');
        }

        $product->update($validated);
        $this->attachWarehouses($product, $validated['warehouses']);

        if ($request->is_mobile) {
            $this->storeMobileDetails($product, $request);
        } else {
            $product->mobileDetail()->delete();
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
        $imageType = $request->input('image_type');

        $imageFields = [
            'image' => 'image',
            'scan_id' => 'scan_id',
            'scan_documents' => 'scan_documents',
        ];

        if (!array_key_exists($imageType, $imageFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid image type.',
            ]);
        }

        $column = $imageFields[$imageType];

        if ($product->$column) {
            Storage::delete($product->$column);

            $product->$column = null;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Image not found.',
        ]);
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

    public function checkBarcode(Request $request)
    {
        $barcode = $request->barcode;
        $productId = $request->product_id;

        $query = Product::where('barcode', $barcode);

        if (!empty($productId)) {
            $query->where('id', '!=', $productId);
        }

        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }

}
