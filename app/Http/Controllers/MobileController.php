<?php

namespace App\Http\Controllers;

use App\Models\Mobile;
use App\Models\Product;
use Illuminate\Http\Request;

class MobileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobiles = Mobile::with('product')->get();
        return view('mobiles.index', compact('mobiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('mobiles.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'imei' => 'required|string|unique:mobiles,imei',
            'status' => 'required|string|in:جديد,مستعمل',
            'specifications' => 'nullable|string',
        ]);

        Mobile::create($validated);

        return redirect()->route('mobiles.index')->with('success', 'تم إضافة الموبايل بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mobile = Mobile::with('product')->findOrFail($id);
        return view('mobiles.show', compact('mobile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mobile = Mobile::findOrFail($id);
        $products = Product::all();
        return view('mobiles.edit', compact('mobile', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'imei' => 'required|string|unique:mobiles,imei,' . $id,
            'status' => 'required|string|in:جديد,مستعمل',
            'specifications' => 'nullable|string',
        ]);

        $mobile = Mobile::findOrFail($id);
        $mobile->update($validated);

        return redirect()->route('mobiles.index')->with('success', 'تم تحديث الموبايل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mobile = Mobile::findOrFail($id);
        $mobile->delete();

        return redirect()->route('mobiles.index')->with('success', 'تم حذف الموبايل بنجاح');
    }
}
