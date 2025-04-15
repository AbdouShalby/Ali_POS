<?php

namespace App\Http\Controllers;

use App\Exports\DebtsExport;
use App\Exports\PurchasesExport;
use App\Exports\SalesExport;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\ExternalPurchase;
use App\Models\Debt;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * عرض تقرير المبيعات المفصل
     */
    public function detailedSales(Request $request) {
        $query = Sale::with(['customer', 'user', 'warehouse', 'products'])->latest();

        // تطبيق الفلاتر
        if ($request->has('from') && $request->has('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->has('warehouse_id') && $request->warehouse_id != '') {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('customer_id') && $request->customer_id != '') {
            $query->where('customer_id', $request->customer_id);
        }

        // حساب الإحصائيات
        $totalSales = $query->count();
        $totalAmount = $query->sum('total_amount');
        $totalTax = $query->sum('tax');
        $totalDiscount = $query->sum('discount');
        
        // الحصول على المبيعات مع التقسيم
        $sales = $query->paginate(10);

        // حساب إجمالي المبيعات حسب طريقة الدفع
        $paymentMethodStats = Sale::selectRaw('payment_method, COUNT(*) as count, SUM(total_amount) as total_amount')
            ->groupBy('payment_method')
            ->get();

        // حساب المبيعات اليومية للرسم البياني
        $dailySales = Sale::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total_amount) as total_amount')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        return view('reports.detailed_sales', [
            'sales' => $sales,
            'totalSales' => $totalSales,
            'totalAmount' => $totalAmount,
            'totalTax' => $totalTax,
            'totalDiscount' => $totalDiscount,
            'paymentMethodStats' => $paymentMethodStats,
            'dailySales' => $dailySales
        ]);
    }
    public function sales(Request $request) {
        $sales = Sale::with(['customer', 'user', 'warehouse'])->latest();

        if ($request->has('from') && $request->has('to')) {
            $sales->whereBetween('created_at', [$request->from, $request->to]);
        }

        if ($request->has('payment_method') && $request->payment_method != '') {
            $sales->where('payment_method', $request->payment_method);
        }

        if ($request->has('warehouse_id') && $request->warehouse_id != '') {
            $sales->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->has('user_id') && $request->user_id != '') {
            $sales->where('user_id', $request->user_id);
        }

        return view('reports.sales', ['sales' => $sales->paginate(10)]);
    }

    public function purchases(Request $request) {
        $purchases = Purchase::latest();

        if ($request->has('from') && $request->has('to')) {
            $purchases->whereBetween('created_at', [$request->from, $request->to]);
        }

        return view('reports.purchases', ['purchases' => $purchases->paginate(10)]);
    }

//    public function expenses(Request $request) {
//        $expenses = ExternalPurchase::latest();
//
//        if ($request->has('from') && $request->has('to')) {
//            $expenses->whereBetween('created_at', [$request->from, $request->to]);
//        }
//
//        return view('reports.expenses', ['expenses' => $expenses->paginate(10)]);
//    }

    public function debts(Request $request) {
        $debts = Debt::where('status', 'unpaid')->latest();

        if ($request->has('from') && $request->has('to')) {
            $debts->whereBetween('created_at', [$request->from, $request->to]);
        }

        return view('reports.debts', ['debts' => $debts->paginate(10)]);
    }

    public function exportSalesPDF()
    {
        $sales = Sale::all();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.exports.sales_pdf', compact('sales'));
        return $pdf->download('sales_report.pdf');
    }

    public function exportDebtPDF()
    {
        $debts = Debt::all();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.exports.debts_pdf', compact('debts'));
        return $pdf->download('debts_report.pdf');
    }

    public function exportPurchasesPDF()
    {
        $purchases = Purchase::all();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.exports.purchases_pdf', compact('purchases'));
        return $pdf->download('purchases_report.pdf');
    }

    public function exportSalesExcel()
    {
        return Excel::download(new SalesExport, 'sales_report.xlsx');
    }

    public function exportDebtsExcel()
    {
        return Excel::download(new DebtsExport, 'debts_report.xlsx');
    }

    public function exportPurchasesExcel()
    {
        return Excel::download(new PurchasesExport, 'purchases_report.xlsx');
    }
}
