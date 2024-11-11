<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExternalPurchase;

class ExternalPurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage external_purchases');
    }

    public function index()
    {
        $externalPurchases = ExternalPurchase::all();
        return view('external_purchases.index', compact('externalPurchases'))->with('activePage', 'external_purchases');
    }

    public function create()
    {
        return view('external_purchases.create')->with('activePage', 'external_purchases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|unique:external_purchases,invoice_number',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
        ]);

        ExternalPurchase::create($validated);

        return redirect()->route('external_purchases.index')->with('success', 'تم إضافة عملية الشراء الخارجية بنجاح');
    }

    public function show($id)
    {
        $externalPurchase = ExternalPurchase::findOrFail($id);
        return view('external_purchases.show', compact('externalPurchase'))->with('activePage', 'external_purchases');
    }

    public function edit($id)
    {
        $externalPurchase = ExternalPurchase::findOrFail($id);
        return view('external_purchases.edit', compact('externalPurchase'))->with('activePage', 'external_purchases');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|unique:external_purchases,invoice_number,' . $id,
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
        ]);

        $externalPurchase = ExternalPurchase::findOrFail($id);
        $externalPurchase->update($validated);

        return redirect()->route('external_purchases.index')->with('success', 'تم تحديث عملية الشراء الخارجية بنجاح');
    }

    public function destroy($id)
    {
        $externalPurchase = ExternalPurchase::findOrFail($id);
        $externalPurchase->delete();

        return redirect()->route('external_purchases.index')->with('success', 'تم حذف عملية الشراء الخارجية بنجاح');
    }
}
