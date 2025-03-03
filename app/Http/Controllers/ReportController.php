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
use PDF;

class ReportController extends Controller
{
    public function sales(Request $request) {
        $sales = Sale::latest();

        if ($request->has('from') && $request->has('to')) {
            $sales->whereBetween('created_at', [$request->from, $request->to]);
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
        $pdf = PDF::loadView('reports.exports.sales_pdf', compact('sales'));
        return $pdf->download('sales_report.pdf');
    }

    public function exportDebtPDF()
    {
        $debts = Debt::all();
        $pdf = PDF::loadView('reports.exports.debts_pdf', compact('debts'));
        return $pdf->download('debts_report.pdf');
    }

    public function exportPurchasesPDF()
    {
        $purchases = Purchase::all();
        $pdf = PDF::loadView('reports.exports.purchases_pdf', compact('purchases'));
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
