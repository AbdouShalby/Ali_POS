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

        // حساب الإحصائيات المفصلة
        $statistics = $this->calculateDetailedStatistics($query);
        
        // الحصول على المعاملات مع الفلترة
        $transactions = $query->when($search, function ($query, $search) {
                $query->where('amount', 'LIKE', "%$search%")
                    ->orWhereHas('cryptoGateway', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%$search%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('crypto_transactions.index', array_merge(
            [
                'transactions' => $transactions,
                'search' => $search,
                'date' => $date,
            ],
            $statistics
        ))->with('activePage', 'crypto_transactions');
    }

    public function create($gatewayId)
    {
        $gateway = CryptoGateway::findOrFail($gatewayId);
        return view('crypto_transactions.create', compact('gateway'))->with('activePage', 'crypto_transactions');
    }

    public function store(Request $request, $gatewayId = null)
    {
        $request->validate([
            'crypto_gateway_id' => $request->has('crypto_gateway_id') ? 'required|exists:crypto_gateways,id' : '',
            'amount' => 'required|numeric',
            'profit_percentage' => 'nullable|numeric',
            'type' => 'required|in:buy,sell'
        ]);

        DB::beginTransaction();

        try {
            // Set crypto_gateway_id from route parameter if not in request
            if (!$request->has('crypto_gateway_id') && $gatewayId) {
                $request->merge(['crypto_gateway_id' => $gatewayId]);
            }

            $transaction = new CryptoTransaction([
                'crypto_gateway_id' => $request->crypto_gateway_id,
                'amount' => $request->amount,
                'profit_percentage' => $request->profit_percentage ?? 0,
                'type' => $request->type
            ]);

            // التحقق من وجود رصيد كافٍ في حالة البيع
            if ($request->type === 'sell') {
                $gateway = CryptoGateway::findOrFail($request->crypto_gateway_id);
                if ($gateway->balance < abs($request->amount)) {
                    throw new \Exception('الرصيد غير كافٍ لإتمام عملية البيع');
                }
            }

            // حساب final_amount و profit_amount قبل الحفظ
            $transaction->calculateFinalAmount();
            
            // حفظ المعاملة
            $transaction->save();
            
            // تحديث الأرصدة
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

        // تطبيق الفلاتر
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

        // حساب الإحصائيات المفصلة
        $statistics = $this->calculateDetailedStatistics($query);

        // الحصول على البوابات للفلتر
        $gateways = CryptoGateway::all();

        // الحصول على المعاملات
        $transactions = $query->latest()->paginate(10);

        return view('crypto_transactions.history', array_merge(
            [
                'transactions' => $transactions,
                'gateways' => $gateways,
                'dateRange' => $dateRange,
                'gateway' => $gateway,
                'type' => $type,
            ],
            $statistics
        ))->with('activePage', 'crypto_transactions.history');
    }

    /**
     * حساب إحصائيات مفصلة للمعاملات
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return array
     */
    private function calculateDetailedStatistics($query)
    {
        // نسخ من الاستعلام للحفاظ على نفس الفلاتر
        $buyQuery = clone $query;
        $sellQuery = clone $query;
        
        // إحصائيات عامة
        $totalTransactions = $query->count();
        
        // إحصائيات المشتريات
        $buyTransactions = $buyQuery->where('type', 'buy')->get();
        $totalBuyTransactions = $buyTransactions->count();
        $totalBuyAmount = $buyTransactions->sum('amount');
        $totalBuyFinalAmount = $buyTransactions->sum('final_amount');
        $buyProfit = $buyTransactions->sum('profit_amount');
        
        // إحصائيات المبيعات
        $sellTransactions = $sellQuery->where('type', 'sell')->get();
        $totalSellTransactions = $sellTransactions->count();
        $totalSellAmount = $sellTransactions->sum('amount');
        $totalSellFinalAmount = $sellTransactions->sum('final_amount');
        $sellProfit = $sellTransactions->sum('profit_amount');
        
        // إجمالي الأرباح
        $totalProfit = $buyProfit + $sellProfit;
        
        // متوسط الربح لكل معاملة
        $averageProfitPerTransaction = $totalTransactions > 0 
            ? $totalProfit / $totalTransactions 
            : 0;
            
        // نسبة الربح من إجمالي المبلغ (للمبيعات والمشتريات)
        $totalAmount = $totalBuyAmount + $totalSellAmount;
        $profitPercentage = $totalAmount > 0 
            ? ($totalProfit / $totalAmount) * 100 
            : 0;
        
        return [
            'totalTransactions' => $totalTransactions,
            'totalBuyTransactions' => $totalBuyTransactions,
            'totalSellTransactions' => $totalSellTransactions,
            'totalBuyAmount' => $totalBuyAmount,
            'totalSellAmount' => $totalSellAmount,
            'totalBuyFinalAmount' => $totalBuyFinalAmount,
            'totalSellFinalAmount' => $totalSellFinalAmount, 
            'buyProfit' => $buyProfit,
            'sellProfit' => $sellProfit,
            'totalProfit' => $totalProfit,
            'averageProfitPerTransaction' => $averageProfitPerTransaction,
            'profitPercentage' => $profitPercentage
        ];
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
