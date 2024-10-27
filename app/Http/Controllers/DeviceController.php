<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage devices');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');

        $devices = Device::when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('color', 'LIKE', "%$search%")
                    ->orWhere('imei', 'LIKE', "%$search%");
            });
        })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('devices.index', compact('devices', 'search'));
    }


    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string',
            'color' => 'nullable|string',
            'battery' => 'nullable|integer|min:0|max:100',
            'storage' => 'nullable|integer',
            'condition' => 'nullable|string',
            'imei' => 'nullable|string',
            'price' => 'nullable|numeric',
        ]);

        $device = Device::create($request->all());

        return redirect()->route('devices.index')->with('success', 'تم إضافة الجهاز بنجاح');
    }

    public function show($id)
    {
        $device = Device::findOrFail($id);

        $data = [];
        if ($device->name) {
            $data[] = "Device: {$device->name}";
        }
        if ($device->color) {
            $data[] = "Color: {$device->color}";
        }
        if ($device->battery) {
            $data[] = "Battery: {$device->battery}%";
        }
        if ($device->storage) {
            $data[] = "Storage: {$device->storage} GB";
        }
        if ($device->condition) {
            $data[] = "Condition: {$device->condition}";
        }
        if ($device->imei) {
            $data[] = "IMEI: {$device->imei}";
        }
        if ($device->price) {
            $data[] = "Price: {$device->price}";
        }

        // تحويل البيانات إلى نص بفواصل الأسطر الجديدة
        $formattedData = implode("\n", $data);

        // إنشاء كائن QrCode
        $qrCode = QrCode::create($formattedData)
            ->setEncoding(new Encoding('UTF-8'))
            ->setSize(300)
            ->setMargin(10);

        // كتابة الـ QR Code باستخدام PngWriter
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // تحويل الناتج إلى Data URI لعرضه في الـ View
        $qrCodeDataUri = $result->getDataUri();

        return view('devices.show', compact('device', 'qrCodeDataUri'));
    }

    public function edit($id)
    {
        $device = Device::findOrFail($id);
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string',
            'color' => 'nullable|string',
            'battery' => 'nullable|integer|min:0|max:100',
            'storage' => 'nullable|integer',
            'condition' => 'nullable|string',
            'imei' => 'nullable|string',
            'price' => 'nullable|numeric',
        ]);

        $device = Device::findOrFail($id);
        $device->update($request->all());

        return redirect()->route('devices.index')->with('success', 'تم تحديث الجهاز بنجاح');
    }

    public function destroy($id)
    {
        $device = Device::findOrFail($id);
        $device->delete();

        return redirect()->route('devices.index')->with('success', 'تم حذف الجهاز بنجاح');
    }
}
