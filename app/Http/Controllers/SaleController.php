<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SaleItem;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage sales');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $date = $request->get('date', now()->toDateString()); // استخدام تاريخ اليوم كافتراضي

        $sales = Sale::with(['customer', 'saleItems.product'])
            ->whereDate('sale_date', $date)
            ->when($search, function ($query, $search) {
                return $query->whereHas('customer', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%$search%");
                })->orWhere('id', $search);
            })
            ->get();

        return view('sales.index', compact('sales', 'search', 'date'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        $categories = Category::all();
        $brands = Brand::all();
        $units = Unit::all();

        return view('sales.create', compact('customers', 'products', 'categories', 'brands', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'sale_date' => 'required|date',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $sale = Sale::create([
            'customer_id' => $request->customer_id,
            'sale_date' => $request->sale_date,
            'total_amount' => 0,
            'notes' => $request->notes,
        ]);

        $totalAmount = 0;

        if (!empty($request->products) && is_array($request->products)) {
            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);
                $quantity = $item['quantity'];
                $price = $item['price'];

                if ($product->quantity < $quantity) {
                    return redirect()->back()->withErrors(['error' => 'الكمية المتوفرة من المنتج ' . $product->name . ' غير كافية']);
                }

                $totalAmount += $price * $quantity;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $product->quantity -= $quantity;
                $product->save();
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'يجب تحديد منتجات الفاتورة.']);
        }

        $sale->total_amount = $totalAmount;
        $sale->save();

        return redirect()->route('sales.index')->with('success', 'تم إضافة فاتورة البيع بنجاح');
    }

    public function show($id)
    {
        $sale = Sale::with(['customer', 'saleItems.product'])->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    public function edit($id)
    {
        $sale = Sale::with('saleItems.product')->findOrFail($id);
        $customers = Customer::all();
        $products = Product::all();

        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'sale_date' => 'required|date',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $sale = Sale::findOrFail($id);
        $sale->update([
            'customer_id' => $request->customer_id,
            'sale_date' => $request->sale_date,
            'notes' => $request->notes,
        ]);

        foreach ($sale->saleItems as $item) {
            $product = $item->product;
            $product->quantity += $item->quantity;
            $product->save();
            $item->delete();
        }

        $totalAmount = 0;
        foreach ($request->products as $item) {
            $product = Product::find($item['product_id']);
            $quantity = $item['quantity'];
            $price = $item['price'];

            if ($product->quantity < $quantity) {
                return redirect()->back()->withErrors(['error' => 'الكمية المتوفرة من المنتج ' . $product->name . ' غير كافية']);
            }

            $totalAmount += $price * $quantity;

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);

            $product->quantity -= $quantity;
            $product->save();
        }

        $sale->total_amount = $totalAmount;
        $sale->save();

        return redirect()->route('sales.index')->with('success', 'تم تعديل عملية البيع بنجاح');
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        // قبل الحذف، يجب تحديث كميات المنتجات
        foreach ($sale->saleItems as $item) {
            $product = $item->product;
            $product->quantity += $item->quantity;
            $product->save();
        }

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'تم حذف فاتورة البيع بنجاح');
    }

    public function history(Request $request)
    {
        $search = $request->get('search');
        $dateFrom = $request->get('from_date');
        $dateTo = $request->get('to_date');

        $sales = Sale::with(['customer', 'saleItems.product'])
            ->when($dateFrom, function ($query, $dateFrom) {
                return $query->whereDate('sale_date', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query, $dateTo) {
                return $query->whereDate('sale_date', '<=', $dateTo);
            })
            ->when($search, function ($query, $search) {
                return $query->whereHas('customer', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%$search%");
                })->orWhere('id', $search);
            })
            ->get();

        return view('sales.history', compact('sales', 'search', 'dateFrom', 'dateTo'));
    }

}
