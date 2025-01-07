@extends('layouts.app')

@section('title', '- Record Payment')

@section('content')
    <div class="container">
        <h1>Record Payment for Debt #{{ $debt->id }}</h1>

        <form action="{{ route('debt.record_payment', $debt->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="amount" class="form-label">Payment Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="1" max="{{ $debt->remainingAmount() }}" required>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">Note (optional)</label>
                <textarea name="note" id="note" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Record Payment</button>
            <a href="{{ route('suppliers.show', $debt->supplier_id) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
