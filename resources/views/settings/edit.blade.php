@extends('layouts.app')

@section('title', 'تعديل الإعداد')

@section('content')
    <div class="container">
        <h1 class="mb-4">تعديل الإعداد: {{ $setting->key }}</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('settings.update', $setting->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- المفتاح -->
            <div class="mb-3">
                <label for="key" class="form-label">المفتاح (Key)</label>
                <input type="text" class="form-control" id="key" name="key" value="{{ old('key', $setting->key) }}" required readonly>
            </div>

            <!-- القيمة -->
            <div class="mb-3">
                <label for="value" class="form-label">القيمة (Value)</label>
                <textarea class="form-control" id="value" name="value" rows="3" required>{{ old('value', $setting->value) }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">تحديث الإعداد</button>
            <a href="{{ route('settings.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
@endsection
