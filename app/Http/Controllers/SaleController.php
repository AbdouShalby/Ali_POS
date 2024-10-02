<?php

namespace App\Http\Controllers;

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

    public function index()
    {
        $sales = Sale::with('customer')->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|unique:sales,invoice_number',
            'customer_id' => 'nullable|exists:customers,id',
            'sale_date' => 'required|date',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $sale = Sale::create([
            'invoice_number' => $request->invoice_number,
            'customer_id' => $request->customer_id,
            'sale_date' => $request->sale_date,
            'total_amount' => 0,
            'notes' => $request->notes,
        ]);

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

        return redirect()->route('sales.index')->with('success', 'تم إضافة فاتورة البيع بنجاح');
    }

    public function show($id)
    {
        $sale = Sale::with(['customer', 'saleItems.product'])->findOrFail($id);
        return view('sales.show', compact('sale'));
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
}
