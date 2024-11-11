<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CryptoGateway;

class CryptoGatewayController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage crypto_gateways');
    }

    public function index()
    {
        $gateways = CryptoGateway::all();
        return view('crypto_gateways.index', compact('gateways'))->with('activePage', 'crypto_gateways');
    }

    public function create()
    {
        return view('crypto_gateways.create')->with('activePage', 'crypto_gateways.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        CryptoGateway::create([
            'name' => $request->name,
            'balance' => 0,
        ]);

        return redirect()->route('crypto_gateways.index')->with('success', 'تم إضافة بوابة العملات المشفرة بنجاح');
    }

    public function edit($id)
    {
        $gateway = CryptoGateway::findOrFail($id);
        return view('crypto_gateways.edit', compact('gateway'))->with('activePage', 'crypto_gateways');
    }

    public function update(Request $request, $id)
    {
        $gateway = CryptoGateway::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $gateway->update([
            'name' => $request->name,
        ]);

        return redirect()->route('crypto_gateways.index')->with('success', 'تم تحديث بوابة العملات المشفرة بنجاح');
    }

    public function show($id)
    {
        $gateway = CryptoGateway::with('transactions')->findOrFail($id);
        return view('crypto_gateways.show', compact('gateway'))->with('activePage', 'crypto_gateways');
    }

    public function destroy($id)
    {
        $gateway = CryptoGateway::findOrFail($id);
        $gateway->delete();

        return redirect()->route('crypto_gateways.index')->with('success', 'تم حذف بوابة العملات المشفرة بنجاح');
    }
}
