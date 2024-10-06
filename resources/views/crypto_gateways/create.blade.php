@extends('layouts.app')

@section('title', 'إضافة بوابة عملات مشفرة جديدة')

@section('content')
    <div class="container">
        <h1 class="mb-4">إضافة بوابة عملات مشفرة جديدة</h1>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('crypto_gateways.store') }}" method="POST">
            @csrf

            <!-- الاسم -->
            <div class="mb-3">
                <label for="name" class="form-label">اسم البوابة</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <button type="submit" class="btn btn-success">حفظ البوابة</button>
            <a href="{{ route('crypto_gateways.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
@endsection
