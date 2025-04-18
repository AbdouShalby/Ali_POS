<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage purchases');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $date = $request->get('date', now()->toDateString());

        $purchases = Purchase::with('supplier')
            ->whereDate('purchase_date', $date)
            ->when($search, function ($query, $search) {
                return $query->where('invoice_number', 'LIKE', "%$search%")
                    ->orWhereHas('supplier', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%$search%");
                    });
            })
            ->get();

        return view('purchases.index', compact('purchases', 'search', 'date'))->with('activePage', 'purchases');
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $categories = Category::all();
        return view('purchases.create', compact('suppliers', 'products', 'categories'))->with('activePage', 'purchases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|unique:purchases,invoice_number',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'invoice_file' => 'nullable|mimes:pdf,jpeg,jpg,png|max:2048',
            'notes' => 'nullable|string',
        ]);

        $invoiceFileName = null;
        if ($request->hasFile('invoice_file')) {
            $invoiceFile = $request->file('invoice_file');
            $fileExtension = $invoiceFile->getClientOriginalExtension();
            $invoiceFileName = time() . '.' . $fileExtension;
            $invoiceFile->move(public_path('invoices'), $invoiceFileName);
        }

        $purchase = Purchase::create([
            'invoice_number' => $request->invoice_number,
            'supplier_id' => $request->supplier_id,
            'purchase_date' => $request->purchase_date,
            'total_amount' => 0,
            'invoice_file' => $invoiceFileName,
            'notes' => $request->notes,
        ]);

        $totalAmount = 0;

        if ($request->has('products')) {
            foreach ($request->products as $item) {
                if (!empty($item['product_id'])) {
                    $product = Product::find($item['product_id']);
                    $quantity = $item['quantity'] ?? 0;
                    $price = $item['price'] ?? 0;
                    $totalAmount += $price * $quantity;

                    PurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);

                    $product->increment('quantity', $quantity);
                }
            }
        }

        $purchase->total_amount = $totalAmount;
        $purchase->save();

        $cashController = new CashRegisterController();
        $cashController->updateBalance(auth()->user()->cash_register_id, $validated['total_amount'], 'purchase', 'Purchase transaction');

        return redirect()->route('purchases.index')->with('success', 'تم إضافة فاتورة الشراء بنجاح');
    }

    public function show($id)
    {
        $purchase = Purchase::with(['supplier', 'purchaseItems.product'])->findOrFail($id);
        return view('purchases.show', compact('purchase'))->with('activePage', 'purchases');
    }

    public function edit($id)
    {
        $purchase = Purchase::with('purchaseItems.product')->findOrFail($id);
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('purchases.edit', compact('purchase', 'suppliers', 'products'))->with('activePage', 'purchases');
    }

    public function update(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        $validated = $request->validate([
            'invoice_number' => 'required|unique:purchases,invoice_number,' . $purchase->id,
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'invoice_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:4096',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $purchase->update([
            'invoice_number' => $request->invoice_number,
            'supplier_id' => $request->supplier_id,
            'purchase_date' => $request->purchase_date,
            'notes' => $request->notes,
        ]);

        if ($request->hasFile('invoice_file')) {
            if ($purchase->invoice_file) {
                Storage::disk('public')->delete($purchase->invoice_file);
            }

            $filePath = $request->file('invoice_file')->store('invoices', 'public');
            $purchase->invoice_file = $filePath;
            $purchase->save();
        }

        $totalAmount = 0;

        foreach ($purchase->purchaseItems as $item) {
            $product = $item->product;
            $product->quantity -= $item->quantity;
            $product->save();
            $item->delete();
        }

        foreach ($request->products as $item) {
            $product = Product::find($item['product_id']);
            $quantity = $item['quantity'];
            $price = $item['price'];
            $totalAmount += $price * $quantity;

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);

            $product->quantity += $quantity;
            $product->save();
        }

        $purchase->total_amount = $totalAmount;
        $purchase->save();

        return redirect()->route('purchases.index')->with('success', 'تم تحديث فاتورة الشراء بنجاح');
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);

        foreach ($purchase->purchaseItems as $item) {
            $product = $item->product;
            $product->quantity -= $item->quantity;
            $product->save();
        }

        $purchase->delete();

        return redirect()->route('purchases.index')->with('success', 'تم حذف فاتورة الشراء بنجاح');
    }

    public function history(Request $request)
    {
        $search = $request->get('search');
        $dateFrom = $request->get('from_date');
        $dateTo = $request->get('to_date');

        $purchases = Purchase::with('supplier')
            ->when($dateFrom, function ($query, $dateFrom) {
                return $query->whereDate('purchase_date', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query, $dateTo) {
                return $query->whereDate('purchase_date', '<=', $dateTo);
            })
            ->when($search, function ($query, $search) {
                return $query->where('invoice_number', 'LIKE', "%$search%")
                    ->orWhereHas('supplier', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%$search%");
                    });
            })
            ->get();

        return view('purchases.history', compact('purchases', 'search', 'dateFrom', 'dateTo'))->with('activePage', 'purchases.history');
    }

    public function getProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();
        return response()->json($products);
    }

    public function print(Purchase $purchase)
    {
        return view('purchases.print', compact('purchase'));
    }

}
