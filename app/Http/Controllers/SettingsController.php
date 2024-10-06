<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage settings');
    }

    public function index()
    {
        $settings = Setting::all();
        return view('settings.index', compact('settings'));
    }

    public function create()
    {
        return view('settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:settings,key',
            'value' => 'required',
        ]);

        Setting::create($request->only('key', 'value'));

        return redirect()->route('settings.index')->with('success', 'تم إضافة الإعداد بنجاح');
    }

    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        return view('settings.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        $request->validate([
            'value' => 'required',
        ]);

        $setting->update([
            'value' => $request->value,
        ]);

        return redirect()->route('settings.index')->with('success', 'تم تحديث الإعداد بنجاح');
    }

    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();

        return redirect()->route('settings.index')->with('success', 'تم حذف الإعداد بنجاح');
    }
}
