<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage customers');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');

        $customers = Customer::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%");
        })->get();

        return view('customers.index', compact('customers', 'search'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'phone' => 'nullable|string|max:20|unique:customers,phone',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $customer = Customer::create($validated);

        if ($customer) {
            return response()->json(['success' => true, 'message' => 'تم إضافة العميل بنجاح']);
        } else {
            return response()->json(['success' => false, 'message' => 'فشل في إضافة العميل']);
        }
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email,' . $id,
            'phone' => 'nullable|string|max:20|unique:customers,phone,' . $id,
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'تم تحديث بيانات العميل بنجاح');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'تم حذف العميل بنجاح');
    }
}
