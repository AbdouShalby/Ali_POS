<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index()
    {
        $revenues = Revenue::orderBy('revenue_date', 'desc')->paginate(10);
        return view('accounting.revenues', compact('revenues'));
    }
}
