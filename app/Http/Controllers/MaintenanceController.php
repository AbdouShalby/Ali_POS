<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Maintenance;
use Picqer\Barcode\BarcodeGeneratorPNG;

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

        return view('maintenances.index', compact('maintenances', 'status', 'search'))->with('activePage', 'maintenances');
    }

    public function create()
    {
        return view('maintenances.create')->with('activePage', 'maintenances.create');
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
        return view('maintenances.show', compact('maintenance'))->with('activePage', 'maintenances');
    }

    public function edit($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        return view('maintenances.edit', compact('maintenance'))->with('activePage', 'maintenances');
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

    private function calculateEAN13CheckDigit($barcode)
    {
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += ($i % 2 === 0 ? 1 : 3) * (int)$barcode[$i];
        }
        $checkDigit = (10 - ($sum % 10)) % 10;
        return $checkDigit;
    }

    public function print($id)
    {
        $maintenance = Maintenance::findOrFail($id);

        do {
            $barcodeNumber = str_pad(mt_rand(1, 999999999999), 12, '0', STR_PAD_LEFT);
            $isUnique = !Product::where('barcode', $barcodeNumber)->exists();
        } while (!$isUnique);

        $checkDigit = $this->calculateEAN13CheckDigit($barcodeNumber);
        $barcodeNumber .= $checkDigit;

        $generator = new BarcodeGeneratorPNG();
        $barcodeImage = base64_encode($generator->getBarcode($barcodeNumber, $generator::TYPE_EAN_13));

        return view('maintenances.print', compact('maintenance', 'barcodeImage', 'barcodeNumber'));
    }
}
