<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobile;
use App\Models\Product;

class MobileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage mobiles');
    }

    public function index()
    {
        $mobiles = Mobile::with('product')->get();
        return view('mobiles.index', compact('mobiles'));
    }

    public function create()
    {
        $products = Product::all();
        return view('mobiles.create', compact('products'));
    }

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

    public function show($id)
    {
        $mobile = Mobile::with('product')->findOrFail($id);
        return view('mobiles.show', compact('mobile'));
    }

    public function edit($id)
    {
        $mobile = Mobile::findOrFail($id);
        $products = Product::all();
        return view('mobiles.edit', compact('mobile', 'products'));
    }

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

    public function destroy($id)
    {
        $mobile = Mobile::findOrFail($id);
        $mobile->delete();

        return redirect()->route('mobiles.index')->with('success', 'تم حذف الموبايل بنجاح');
    }
}
