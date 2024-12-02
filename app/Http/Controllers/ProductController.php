<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
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
        $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'required|string|max:255|unique:products,barcode',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'quantity' => 'required|integer',
            'stock_alert' => 'required|integer|min:0',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'wholesale_price' => 'required|numeric',
            'min_sale_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_mobile' => 'nullable|boolean',
            'client_type' => 'nullable|string|in:customer,supplier',
            'customer_id' => 'nullable|exists:customers,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'payment_method' => 'nullable|string|in:cash,credit',
            'seller_name' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
        } else {
            $imageName = null;
        }

        if ($request->hasFile('scan_id')) {
            $scanIdName = time() . '_scan_id.' . $request->scan_id->extension();
            $request->scan_id->move(public_path('files/scan_ids'), $scanIdName);
        } else {
            $scanIdName = null;
        }

        if ($request->hasFile('scan_documents')) {
            $scanDocumentName = time() . '_scan_document.' . $request->scan_documents->extension();
            $request->scan_documents->move(public_path('files/scan_documents'), $scanDocumentName);
        } else {
            $scanDocumentName = null;
        }

        $barcodeGenerator = new BarcodeGeneratorHTML();
        $barcode = rand(100000000000, 999999999999);
        $barcodeHTML = $barcodeGenerator->getBarcode($barcode, $barcodeGenerator::TYPE_CODE_128);

        $product = Product::create([
            'name' => $request->name,
            'barcode' => $barcode,
            'description' => $request->description,
            'image' => $imageName,
            'cost' => $request->cost,
            'price' => $request->price,
            'wholesale_price' => $request->wholesale_price,
            'min_sale_price' => $request->min_sale_price,
            'quantity' => $request->quantity,
            'stock_alert' => $request->stock_alert,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'client_type' => $request->client_type,
            'customer_id' => $request->client_type == 'customer' ? $request->customer_id : null,
            'supplier_id' => $request->client_type == 'supplier' ? $request->supplier_id : null,
            'payment_method' => $request->payment_method,
            'seller_name' => $request->seller_name,
            'scan_id' => $scanIdName,
            'scan_documents' => $scanDocumentName,
        ]);

        if ($request->warehouse_id) {
            $product->warehouses()->attach($request->warehouse_id, ['stock' => $request->quantity]);
        }

        if ($request->is_mobile) {
            $request->validate([
                'color' => 'nullable|string|max:255',
                'storage' => 'nullable|string|max:255',
                'battery_health' => 'nullable|numeric|min:0|max:100',
                'ram' => 'nullable|string|max:255',
                'gpu' => 'nullable|string|max:255',
                'cpu' => 'nullable|string|max:255',
                'condition' => 'nullable|string|max:255',
                'device_description' => 'nullable|string',
                'has_box' => 'nullable|boolean',
            ]);

            $product->mobileDetail()->create([
                'color' => $request->color,
                'storage' => $request->storage,
                'battery_health' => $request->battery_health,
                'ram' => $request->ram,
                'gpu' => $request->gpu,
                'cpu' => $request->cpu,
                'condition' => $request->condition,
                'device_description' => $request->device_description,
                'has_box' => $request->has_box ? true : false,
            ]);
        }

        return redirect()->route('products.index')->with('success', __('The Product Has Been Added Successfully.'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'brand', 'mobileDetail'])->findOrFail($id);
        return view('products.show', compact('product'))->with('activePage', 'products');
    }

    public function edit($id)
    {
        $product = Product::with(['mobileDetail', 'warehouse'])->findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $customers = Customer::all();
        $warehouses = Warehouse::all();

        return view('products.edit', compact('product', 'categories', 'brands', 'suppliers', 'customers', 'warehouses'))
            ->with('activePage', 'products');
    }


    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:products,code,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'quantity' => 'required|integer',
            'stock_alert' => 'required|integer|min:0',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'wholesale_price' => 'required|numeric',
            'min_sale_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_mobile' => 'nullable|boolean',
            'client_type' => 'nullable|string|in:customer,supplier',
            'customer_id' => 'nullable|exists:customers,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'payment_method' => 'nullable|string|in:cash,credit',
            'seller_name' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
                unlink(public_path('images/products/' . $product->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
        } else {
            $imageName = $product->image;
        }

        $product->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'image' => $imageName,
            'cost' => $request->cost,
            'price' => $request->price,
            'wholesale_price' => $request->wholesale_price,
            'min_sale_price' => $request->min_sale_price,
            'quantity' => $request->quantity,
            'stock_alert' => $request->stock_alert,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'client_type' => $request->client_type,
            'customer_id' => $request->client_type == 'customer' ? $request->customer_id : null,
            'supplier_id' => $request->client_type == 'supplier' ? $request->supplier_id : null,
            'payment_method' => $request->payment_method,
            'seller_name' => $request->seller_name,
            'is_mobile' => $request->has('is_mobile') ? true : false,
        ]);

        if ($request->is_mobile) {
            $request->validate([
                'color' => 'nullable|string|max:255',
                'storage' => 'nullable|string|max:255',
                'battery_health' => 'nullable|numeric|min:0|max:100',
                'ram' => 'nullable|string|max:255',
                'gpu' => 'nullable|string|max:255',
                'cpu' => 'nullable|string|max:255',
                'condition' => 'nullable|string|max:255',
                'device_description' => 'nullable|string',
                'has_box' => 'nullable|boolean',
            ]);

            if ($product->mobileDetail) {
                $product->mobileDetail()->update([
                    'color' => $request->color,
                    'storage' => $request->storage,
                    'battery_health' => $request->battery_health,
                    'ram' => $request->ram,
                    'gpu' => $request->gpu,
                    'cpu' => $request->cpu,
                    'condition' => $request->condition,
                    'device_description' => $request->device_description,
                    'has_box' => $request->has_box ? true : false,
                ]);
            } else {
                $product->mobileDetail()->create([
                    'color' => $request->color,
                    'storage' => $request->storage,
                    'battery_health' => $request->battery_health,
                    'ram' => $request->ram,
                    'gpu' => $request->gpu,
                    'cpu' => $request->cpu,
                    'condition' => $request->condition,
                    'device_description' => $request->device_description,
                    'has_box' => $request->has_box ? true : false,
                ]);
            }
        } else {
            if ($product->mobileDetail) {
                $product->mobileDetail()->delete();
            }
        }

        return redirect()->route('products.index')->with('success', __('The Product Has Been Updated Successfully.'));
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
