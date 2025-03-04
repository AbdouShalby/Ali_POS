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

    public function index(Request $request)
    {
        $search = $request->get('search');
        $date = $request->get('date', now()->toDateString());

        $transactions = CryptoTransaction::with('cryptoGateway')
            ->whereDate('created_at', $date)
            ->when($search, function ($query, $search) {
                $query->where('amount', 'LIKE', "%$search%")
                    ->orWhereHas('cryptoGateway', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%$search%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('crypto_transactions.index', compact('transactions', 'search', 'date'))->with('activePage', 'crypto_transactions');
    }


    public function create($gatewayId)
    {
        $gateway = CryptoGateway::findOrFail($gatewayId);
        return view('crypto_transactions.create', compact('gateway'))->with('activePage', 'crypto_transactions');
    }

    public function store(Request $request)
    {
        $request->validate([
            'crypto_gateway_id' => 'required|exists:crypto_gateways,id',
            'amount' => 'required|numeric',
            'profit_percentage' => 'nullable|numeric|min:0|max:100'
        ]);

        $transaction = CryptoTransaction::create([
            'crypto_gateway_id' => $request->crypto_gateway_id,
            'amount' => $request->amount,
            'profit_percentage' => $request->profit_percentage
        ]);

        $transaction->cryptoGateway->updateBalance($request->amount);

        return redirect()->route('crypto-transactions.index')
            ->with('success', 'Transaction recorded successfully.');
    }

    public function history(Request $request)
    {
        $search = $request->get('search');
        $dateFrom = $request->get('from_date');
        $dateTo = $request->get('to_date');

        $transactions = CryptoTransaction::with('cryptoGateway')
            ->when($dateFrom, function ($query, $dateFrom) {
                return $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query, $dateTo) {
                return $query->whereDate('created_at', '<=', $dateTo);
            })
            ->when($search, function ($query, $search) {
                $query->where('amount', 'LIKE', "%$search%")
                    ->orWhereHas('cryptoGateway', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%$search%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('crypto_transactions.history', compact('transactions', 'search', 'dateFrom', 'dateTo'))->with('activePage', 'crypto_transactions.history');
    }
}
