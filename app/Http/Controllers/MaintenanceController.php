<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maintenance;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage maintenances');
    }

    public function index(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');

        $maintenances = Maintenance::when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('customer_name', 'LIKE', "%$search%")
                        ->orWhere('phone_number', 'LIKE', "%$search%")
                        ->orWhere('device_type', 'LIKE', "%$search%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('maintenances.index', compact('maintenances', 'status', 'search'));
    }

    public function create()
    {
        return view('maintenances.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'device_type' => 'required|string|max:255',
            'problem_description' => 'required|string',
            'cost' => 'nullable|numeric|min:0',
            'password' => 'nullable|string|max:255',
        ]);

        Maintenance::create($request->all());

        return redirect()->route('maintenances.index')->with('success', 'تم إضافة عملية الصيانة بنجاح');
    }

    public function show($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        return view('maintenances.show', compact('maintenance'));
    }

    public function edit($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        return view('maintenances.edit', compact('maintenance'));
    }

    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'device_type' => 'required|string|max:255',
            'problem_description' => 'required|string',
            'cost' => 'nullable|numeric|min:0',
            'password' => 'nullable|string|max:255',
            'status' => 'required|in:in_maintenance,completed,delivered',
        ]);

        $maintenance->update($request->all());

        return redirect()->route('maintenances.index')->with('success', 'تم تحديث عملية الصيانة بنجاح');
    }

    public function destroy($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->route('maintenances.index')->with('success', 'تم حذف عملية الصيانة بنجاح');
    }
}
