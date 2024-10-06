<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CryptoGateway;
use App\Models\CryptoTransaction;

class CryptoTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage crypto_transactions');
    }

    public function index()
    {
        $transactions = CryptoTransaction::with('cryptoGateway')->latest()->paginate(10);
        return view('crypto_transactions.index', compact('transactions'));
    }


    public function create($gatewayId)
    {
        $gateway = CryptoGateway::findOrFail($gatewayId);
        return view('crypto_transactions.create', compact('gateway'));
    }

    public function store(Request $request, $gatewayId)
    {
        $gateway = CryptoGateway::findOrFail($gatewayId);

        $request->merge([
            'includes_fees' => $request->has('includes_fees'),
        ]);

        $request->validate([
            'type' => 'required|in:buy,sell',
            'amount' => 'required|numeric|min:0.00000001',
            'includes_fees' => 'boolean',
        ]);


        $amount = $request->amount;

        if ($request->type == 'sell') {
            if ($gateway->balance < $amount) {
                return redirect()->back()->withErrors('الرصيد غير كافٍ لإتمام عملية البيع');
            }
            $gateway->balance -= $amount;
        } else {
            $gateway->balance += $amount;
        }

        $gateway->save();

        CryptoTransaction::create([
            'crypto_gateway_id' => $gateway->id,
            'type' => $request->type,
            'amount' => $amount,
            'includes_fees' => $request->includes_fees ? true : false,
        ]);

        return redirect()->route('crypto_gateways.index')->with('success', 'تم تنفيذ العملية بنجاح');
    }
}
