@extends('layouts.app')
@section('content')
    <div class="container">
        <h3 class="mb-4">{{ __('payments.add') }}</h3>
        <form action="{{ route('accounting.payments.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">{{ __('payments.amount') }}</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="payment_date" class="form-label">{{ __('payments.date') }}</label>
                <input type="date" name="payment_date" id="payment_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="payment_type" class="form-label">{{ __('payments.type') }}</label>
                <select name="payment_type" id="payment_type" class="form-control" required>
                    <option value="customer">{{ __('payments.customer') }}</option>
                    <option value="supplier">{{ __('payments.supplier') }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">{{ __('payments.save') }}</button>
        </form>
    </div>
@endsection
