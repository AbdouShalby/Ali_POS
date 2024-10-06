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

        $maintenances = Maintenance::when($status, function ($query, $status) {
            return $query->where('status', $status);
        })->orderBy('created_at', 'desc')->get();

        return view('maintenances.index', compact('maintenances', 'status'));
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

    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $request->validate([
            'status' => 'required|in:in_maintenance,completed,delivered',
        ]);

        $maintenance->update($request->only('status'));

        return redirect()->route('maintenances.index')->with('success', 'تم تحديث حالة الصيانة بنجاح');
    }
}
