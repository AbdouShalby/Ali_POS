<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage products');
    }

    public function index()
    {
        $products = Product::with(['category', 'brand', 'mobileDetail'])->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $units = Unit::all();
        $suppliers = Supplier::all();
        $customers = Customer::all();
        return view('products.create', compact('categories', 'brands', 'units', 'suppliers', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:products,code',
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

        $product = Product::create([
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
            'unit_id' => $request->unit_id,
            'sale_unit_id' => $request->sale_unit_id,
            'purchase_unit_id' => $request->purchase_unit_id,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'client_type' => $request->client_type,
            'customer_id' => $request->client_type == 'customer' ? $request->customer_id : null,
            'supplier_id' => $request->client_type == 'supplier' ? $request->supplier_id : null,
            'payment_method' => $request->payment_method,
            'seller_name' => $request->seller_name,
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

        return redirect()->route('products.index')->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function show($id)
    {
        $product = Product::with(['brand', 'category'])->findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        $units = Unit::all();
        $suppliers = Supplier::all();
        $customers = Customer::all();
        return view('products.edit', compact('product', 'categories', 'brands', 'units', 'suppliers', 'customers'));
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
            'unit_id' => $request->unit_id,
            'sale_unit_id' => $request->sale_unit_id,
            'purchase_unit_id' => $request->purchase_unit_id,
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

        return redirect()->route('products.index')->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'تم حذف المنتج بنجاح');
    }
}
