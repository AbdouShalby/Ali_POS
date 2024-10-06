@extends('layouts.app')

@section('title', 'إضافة جهاز جديد')

@section('content')
    <div class="container">
        <h1>إضافة جهاز جديد</h1>

        <form action="{{ route('devices.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">اسم الجهاز (اختياري)</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>

            <div class="mb-3">
                <label for="color" class="form-label">اللون (اختياري)</label>
                <input type="text" class="form-control" id="color" name="color">
            </div>

            <div class="mb-3">
                <label for="battery" class="form-label">حالة البطارية (%) (اختياري)</label>
                <input type="number" class="form-control" id="battery" name="battery">
            </div>

            <div class="mb-3">
                <label for="storage" class="form-label">السعة التخزينية (GB) (اختياري)</label>
                <input type="number" class="form-control" id="storage" name="storage">
            </div>

            <div class="mb-3">
                <label for="condition" class="form-label">الحالة (اختياري)</label>
                <input type="text" class="form-control" id="condition" name="condition">
            </div>

            <div class="mb-3">
                <label for="imei" class="form-label">IMEI (اختياري)</label>
                <input type="text" class="form-control" id="imei" name="imei">
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">السعر ($) (اختياري)</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price">
            </div>

            <button type="submit" class="btn btn-primary">إضافة</button>
        </form>
    </div>
@endsection
