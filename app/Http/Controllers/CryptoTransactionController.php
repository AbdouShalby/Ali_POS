<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CryptoGateway;
use App\Models\CryptoTransaction;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CryptoTransactionsExport;

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

        $query = CryptoTransaction::with('cryptoGateway')
            ->whereDate('created_at', $date);

        // Calculate statistics
        $totalTransactions = $query->count();
        $totalBuyAmount = $query->where('type', 'buy')->sum('amount');
        $totalSellAmount = abs($query->where('type', 'sell')->sum('amount'));
        $totalProfit = $query->sum('profit_amount');

        $transactions = $query->when($search, function ($query, $search) {
                $query->where('amount', 'LIKE', "%$search%")
                    ->orWhereHas('cryptoGateway', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%$search%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('crypto_transactions.index', compact(
            'transactions', 
            'search', 
            'date',
            'totalTransactions',
            'totalBuyAmount',
            'totalSellAmount',
            'totalProfit'
        ))->with('activePage', 'crypto_transactions');
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
            'profit_percentage' => 'nullable|numeric',
            'type' => 'required|in:buy,sell'
        ]);

        DB::beginTransaction();

        try {
            $transaction = new CryptoTransaction([
                'crypto_gateway_id' => $request->crypto_gateway_id,
                'amount' => $request->amount,
                'profit_percentage' => $request->profit_percentage,
                'type' => $request->type
            ]);

            // التحقق من وجود رصيد كافٍ في حالة البيع
            if ($request->type === 'sell') {
                $gateway = CryptoGateway::findOrFail($request->crypto_gateway_id);
                if ($gateway->balance < abs($request->amount)) {
                    throw new \Exception('الرصيد غير كافٍ لإتمام عملية البيع');
                }
            }

            $transaction->save();
            $transaction->updateBalances();

            DB::commit();

            return redirect()->route('crypto_transactions.index')
                ->with('success', 'تم تنفيذ المعاملة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'حدث خطأ: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function history(Request $request)
    {
        $dateRange = $request->get('date_range');
        $gateway = $request->get('gateway');
        $type = $request->get('type');

        $query = CryptoTransaction::with('cryptoGateway');

        if ($dateRange) {
            $dates = explode(' - ', $dateRange);
            if (count($dates) == 2) {
                $query->whereDate('created_at', '>=', $dates[0])
                      ->whereDate('created_at', '<=', $dates[1]);
            }
        }

        if ($gateway) {
            $query->where('crypto_gateway_id', $gateway);
        }

        if ($type) {
            $query->where('type', $type);
        }

        // Calculate statistics
        $totalTransactions = $query->count();
        $totalBuyAmount = $query->where('type', 'buy')->sum('amount');
        $totalSellAmount = abs($query->where('type', 'sell')->sum('amount'));
        $totalProfit = $query->sum('profit_amount');

        // Get gateways for filter
        $gateways = CryptoGateway::all();

        $transactions = $query->latest()->paginate(10);

        return view('crypto_transactions.history', compact(
            'transactions',
            'gateways',
            'dateRange',
            'gateway',
            'type',
            'totalTransactions',
            'totalBuyAmount',
            'totalSellAmount',
            'totalProfit'
        ))->with('activePage', 'crypto_transactions.history');
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'excel');
        $fileName = 'crypto_transactions_' . now()->format('Y_m_d_H_i_s');

        // بناء الاستعلام بناءً على المعايير
        $query = CryptoTransaction::with('cryptoGateway');

        // تطبيق الفلاتر
        if ($request->has('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) == 2) {
                $query->whereDate('created_at', '>=', $dates[0])
                      ->whereDate('created_at', '<=', $dates[1]);
            }
        }

        if ($request->has('gateway')) {
            $query->where('crypto_gateway_id', $request->gateway);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->get();

        if ($format === 'excel') {
            return Excel::download(new CryptoTransactionsExport($transactions), $fileName . '.xlsx');
        }

        // يمكن إضافة تصدير PDF هنا إذا كان مطلوباً
        return back()->with('error', 'صيغة التصدير غير مدعومة');
    }
}
