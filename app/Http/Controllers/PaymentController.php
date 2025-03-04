<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Debt;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['customer', 'supplier', 'debt'])
            ->orderBy('payment_date', 'desc')
            ->paginate(10);

        return view('accounting.payments', compact('payments'));
    }

    public function create()
    {
        $customers = Customer::all();
        $suppliers = Supplier::all();
        $debts = Debt::where('status', 'unpaid')->get();

        return view('accounting.create_payment', compact('customers', 'suppliers', 'debts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_type' => 'required|in:customer,supplier',
            'customer_id' => 'nullable|exists:customers,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'debt_id' => 'nullable|exists:debts,id',
            'note' => 'nullable|string|max:255',
        ]);

        Payment::create($request->all());

        return redirect()->route('accounting.payments')->with('success', 'تمت إضافة الدفعة بنجاح.');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('accounting.payments')->with('success', 'تم حذف الدفعة بنجاح.');
    }
}
