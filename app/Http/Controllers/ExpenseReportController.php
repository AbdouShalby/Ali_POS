<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseReportController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderBy('expense_date', 'desc')->paginate(10);
        return view('reports.expenses', compact('expenses'));
    }
}
