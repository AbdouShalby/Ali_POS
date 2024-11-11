<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage categories');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');

        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%");
        })->get();

        return view('categories.index', compact('categories', 'search'))->with('activePage', 'categories');
    }

    public function create()
    {
        return view('categories.create')->with('activePage', 'categories');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:255',
        ]);

        $category = Category::create($request->all());

        return response()->json([
            'success' => true,
            'category_id' => $category->id,
        ]);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'))->with('activePage', 'categories');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'))->with('activePage', 'categories');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'تم حذف القسم بنجاح');
    }
}
