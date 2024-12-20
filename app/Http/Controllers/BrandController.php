<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $brands = Brand::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
        })->get();

        return view('brands.index', compact('brands', 'search'))->with('activePage', 'brands');
    }

    public function create()
    {
        return view('brands.create')->with('activePage', 'brands');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $brand = Brand::create($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Brand added successfully.',
            'brand' => $brand,
        ]);
    }

    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return view('brands.show', compact('brand'))->with('activePage', 'brands');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('brands.edit', compact('brand'))->with('activePage', 'brands');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $id,
            'description' => 'nullable|string|max:255',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->update($validated);

        return redirect()->route('brands.index')->with('success', 'تم تحديث البراند بنجاح');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'تم حذف البراند بنجاح');
    }
}
