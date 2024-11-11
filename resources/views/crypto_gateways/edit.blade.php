@extends('layouts.app')

@section('title', '- ' . __('Edit Cryptocurrency Gateway'))

@section('content')
    <div class="container">
        <h1 class="mb-4">تعديل بوابة العملات المشفرة: {{ $gateway->name }}</h1>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('crypto_gateways.update', $gateway->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- الاسم -->
            <div class="mb-3">
                <label for="name" class="form-label">اسم البوابة</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $gateway->name) }}" required>
            </div>

            <button type="submit" class="btn btn-success">تحديث البوابة</button>
            <a href="{{ route('crypto_gateways.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
@endsection
