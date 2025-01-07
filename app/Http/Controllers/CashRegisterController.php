<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use Illuminate\Http\Request;

class CashRegisterController extends Controller
{
    public function index()
    {
        $transactions = CashRegister::orderBy('created_at', 'desc')->paginate(10);
        return view('cash-register.index', compact('transactions'))->with('activePage', 'cash_register');
    }

    public function log(Request $request)
    {
        $query = CashRegister::query();

        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }

        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);
        return view('cash-register.log', compact('transactions'))->with('activePage', 'cash_register_log');
    }

    public function dailyDetails($date)
    {
        $transactions = CashRegister::whereDate('created_at', $date)->orderBy('created_at', 'desc')->get();
        return view('cash-register.daily-details', compact('transactions', 'date'))->with('activePage', 'cash_register');
    }

    public function transactionDetails($id)
    {
        $transaction = CashRegister::findOrFail($id);
        return view('cash-register.transaction-details', compact('transaction'))->with('activePage', 'cash_register');
    }

    public function report(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = CashRegister::query();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        $totalIn = $transactions->where('amount', '>', 0)->sum('amount');
        $totalOut = $transactions->where('amount', '<', 0)->sum('amount');
        $netTotal = $totalIn + $totalOut;

        return view('cash-register.report', compact('transactions', 'totalIn', 'totalOut', 'netTotal', 'startDate', 'endDate'))->with('activePage', 'cash_register_report');
    }

    public function charts()
    {
        $data = CashRegister::selectRaw('
            DATE_FORMAT(created_at, "%Y-%m") as month,
            SUM(CASE WHEN amount > 0 THEN amount ELSE 0 END) as total_income,
            SUM(CASE WHEN amount < 0 THEN amount ELSE 0 END) as total_expense
        ')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = $data->pluck('month');
        $income = $data->pluck('total_income');
        $expenses = $data->pluck('total_expense');

        return view('cash-register.charts', compact('months', 'income', 'expenses'))->with('activePage', 'cash_register_charts');
    }

}
