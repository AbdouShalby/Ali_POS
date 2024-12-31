<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $warehouses = Warehouse::paginate(10);
        return view('warehouses.index', compact('warehouses'))->with('activePage', 'warehouses');
    }

    public function create()
    {
        return view('warehouses.create')->with('activePage', 'warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Warehouse::create($request->all());

        return redirect()->route('warehouses.index')->with('success', __('Warehouse added successfully.'));
    }

    public function show($id)
    {
        $warehouse = Warehouse::with('products')->findOrFail($id);
        return view('warehouses.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'))->with('activePage', 'warehouses');
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $warehouse->update($request->all());

        return redirect()->route('warehouses.index')->with('success', __('Warehouse updated successfully.'));
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        return redirect()->route('warehouses.index')->with('success', __('Warehouse deleted successfully.'));
    }

    public function getProducts(Warehouse $warehouse)
    {
        try {
            // جلب المنتجات مع المخزون
            $products = $warehouse->products()->get()->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'stock' => $product->pivot->stock, // تأكد من أن علاقة pivot تحتوي على stock
                ];
            });

            return response()->json($products, 200); // إرسال JSON
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
