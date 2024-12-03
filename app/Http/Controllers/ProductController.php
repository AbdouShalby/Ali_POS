<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage products');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');
        $brand = $request->get('brand');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $barcode = $request->get('barcode');
        $sellingPrice = $request->get('selling_price');

        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
            ->when($barcode, function ($query, $barcode) {
                return $query->where('barcode', 'like', '%' . $barcode . '%');
            })
            ->when($category, function ($query, $category) {
                return $query->where('category_id', $category);
            })
            ->when($brand, function ($query, $brand) {
                return $query->where('brand_id', $brand);
            })
            ->when($minPrice, function ($query, $minPrice) {
                return $query->where('price', '>=', $minPrice);
            })
            ->when($maxPrice, function ($query, $maxPrice) {
                return $query->where('price', '<=', $maxPrice);
            })
            ->when($sellingPrice, function ($query, $sellingPrice) {
                return $query->where('price', $sellingPrice);
            })
            ->orderBy('created_at', 'desc')->paginate(10);

        $categories = Category::all();
        $brands = Brand::all();
        return view('products.index', compact('products', 'categories', 'brands', 'search', 'category', 'brand', 'minPrice', 'maxPrice', 'barcode', 'sellingPrice'))
            ->with('activePage', 'products');
    }


    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $customers = Customer::all();
        $warehouses = Warehouse::all();
        return view('products.create', compact('categories', 'brands', 'suppliers', 'customers', 'warehouses'))->with('activePage', 'products.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'is_mobile' => $request->has('is_mobile') ? true : false,
        ]);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'barcode' => 'required|string|max:255|unique:products,barcode',
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
            'is_mobile' => 'nullable|boolean',
            'color' => 'nullable|string|max:255',
            'storage' => 'nullable|string|max:255',
            'battery_health' => 'nullable|numeric|min:0|max:100',
            'ram' => 'nullable|string|max:255',
            'gpu' => 'nullable|string|max:255',
            'cpu' => 'nullable|string|max:255',
            'condition' => 'nullable|string|max:255',
            'device_description' => 'nullable|string',
            'has_box' => 'nullable|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        Log::info('Validation passed successfully:', $validated);

        // Handle file uploads
        $imageName = $request->hasFile('image') ? $request->file('image')->store('products/images', 'public') : null;
        $scanIdName = $request->hasFile('scan_id') ? $request->file('scan_id')->store('products/scan_ids', 'public') : null;
        $scanDocumentName = $request->hasFile('scan_documents') ? $request->file('scan_documents')->store('products/scan_documents', 'public') : null;

        $barcode = $request->barcode ?: rand(100000000000, 999999999999);

        // Create product
        $product = Product::create([
            'name' => $validated['name'],
            'barcode' => $barcode,
            'cost' => $validated['cost'],
            'price' => $validated['price'],
            'wholesale_price' => $validated['wholesale_price'],
            'min_sale_price' => $validated['min_sale_price'],
            'description' => $request->description,
            'image' => $imageName,
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
            'client_type' => $request->client_type ?? null,
            'customer_id' => $request->client_type === 'customer' ? $request->customer_id : null,
            'supplier_id' => $request->client_type === 'supplier' ? $request->supplier_id : null,
            'payment_method' => $request->payment_method ?? null,
            'seller_name' => $request->seller_name ?? auth()->user()->name,
            'scan_id' => $scanIdName,
            'scan_documents' => $scanDocumentName,
            'is_mobile' => $request->is_mobile ? true : false,
        ]);

        Log::info('Product created successfully:', $product->toArray());

        // Attach warehouses
        foreach ($validated['warehouses'] as $warehouse) {
            $product->warehouses()->attach($warehouse['id'], [
                'stock' => $warehouse['stock'],
                'stock_alert' => $warehouse['stock_alert'],
            ]);
        }

        Log::info('Warehouses attached successfully to product ID:', [$product->id]);

        // Handle mobile details if applicable
        if ($request->is_mobile) {
            $mobileDetailsRules = [
                'color' => 'nullable|string|max:255',
                'storage' => 'nullable|string|max:255',
                'battery_health' => 'nullable|numeric|min:0|max:100',
                'ram' => 'nullable|string|max:255',
                'gpu' => 'nullable|string|max:255',
                'cpu' => 'nullable|string|max:255',
                'condition' => 'nullable|string|max:255',
                'device_description' => 'nullable|string',
                'has_box' => 'nullable|boolean',
            ];

            $mobileValidator = Validator::make($request->all(), $mobileDetailsRules);

            if ($mobileValidator->fails()) {
                Log::error('Mobile details validation failed:', $mobileValidator->errors()->toArray());
                return redirect()->back()->withErrors($mobileValidator)->withInput();
            }

            $mobileValidated = $mobileValidator->validated();

            $product->mobileDetail()->create($mobileValidated);

            Log::info('Mobile details added successfully for product ID:', [$product->id]);
        }

        return redirect()->route('products.index')->with('success', __('The Product Has Been Added Successfully.'));
    }

    public function show(Product $product)
    {
        $product = Product::with(['category', 'brand', 'mobileDetail', 'warehouses'])->findOrFail($product->id);

        return view('products.show', compact('product'))->with('activePage', 'products');
    }

    public function edit($id)
    {
        $product = Product::with(['mobileDetail', 'warehouses'])->findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $customers = Customer::all();
        $warehouses = Warehouse::all();

        return view('products.edit', compact('product', 'categories', 'brands', 'suppliers', 'customers', 'warehouses'))
            ->with('activePage', 'products');
    }

    public function update(Request $request, Product $product)
    {
        $request->merge(['is_mobile' => $request->has('is_mobile')]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => "required|string|max:255|unique:products,barcode,{$product->id}",
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
            'color' => 'nullable|string|max:255',
            'storage' => 'nullable|string|max:255',
            'battery_health' => 'nullable|numeric|min:0|max:100',
            'ram' => 'nullable|string|max:255',
            'gpu' => 'nullable|string|max:255',
            'cpu' => 'nullable|string|max:255',
            'condition' => 'nullable|string|max:255',
            'device_description' => 'nullable|string',
            'has_box' => 'nullable|boolean',
            'client_type' => 'nullable|string|in:customer,supplier',
            'customer_id' => 'nullable|exists:customers,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'payment_method' => 'nullable|string|in:cash,credit',
            'scan_id' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'scan_documents' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products/images', 'public');
            $product->image = $imagePath;
        }

        if ($request->hasFile('scan_id')) {
            $scanIdPath = $request->file('scan_id')->store('products/scan_ids', 'public');
            $product->scan_id = $scanIdPath;
        }

        if ($request->hasFile('scan_documents')) {
            $scanDocumentsPath = $request->file('scan_documents')->store('products/scan_documents', 'public');
            $product->scan_documents = $scanDocumentsPath;
        }

        $product->update([
            'name' => $validated['name'],
            'barcode' => $validated['barcode'],
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
            'cost' => $validated['cost'],
            'price' => $validated['price'],
            'wholesale_price' => $validated['wholesale_price'],
            'min_sale_price' => $validated['min_sale_price'],
            'description' => $request->description,
            'client_type' => $validated['client_type'] ?? null,
            'customer_id' => $validated['client_type'] === 'customer' ? $validated['customer_id'] : null,
            'supplier_id' => $validated['client_type'] === 'supplier' ? $validated['supplier_id'] : null,
            'payment_method' => $validated['payment_method'] ?? null,
            'seller_name' => $request->seller_name ?? null,
        ]);

        $product->warehouses()->detach();
        foreach ($validated['warehouses'] as $warehouse) {
            $product->warehouses()->attach($warehouse['id'], [
                'stock' => $warehouse['stock'],
                'stock_alert' => $warehouse['stock_alert'],
            ]);
        }

        if ($request->is_mobile) {
            $product->mobileDetail()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'color' => $validated['color'],
                    'storage' => $validated['storage'],
                    'battery_health' => $validated['battery_health'],
                    'ram' => $validated['ram'],
                    'gpu' => $validated['gpu'],
                    'cpu' => $validated['cpu'],
                    'condition' => $validated['condition'],
                    'device_description' => $validated['device_description'],
                    'has_box' => $validated['has_box'] ?? false,
                ]
            );
        } else {
            $product->mobileDetail()->delete();
        }

        return redirect()->route('products.index')->with('success', __('Product updated successfully.'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', __('The Product Has Been Deleted Successfully.'));
    }

    public function generateBarcode()
    {
        do {
            $barcode = mt_rand(1000000000000, 9999999999999);
        } while (Product::where('barcode', $barcode)->exists());

        return response()->json(['success' => true, 'barcode' => $barcode], 200, ['Content-Type' => 'application/json']);
    }
}
