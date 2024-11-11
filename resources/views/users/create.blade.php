@extends('layouts.app')

@section('title', '- ' . __('Create User'))

@section('content')
    <div class="container">
        <h1 class="mb-4">إضافة مستخدم جديد</h1>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <!-- الاسم -->
            <div class="mb-3">
                <label for="name" class="form-label">الاسم</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <!-- البريد الإلكتروني -->
            <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <!-- كلمة المرور -->
            <div class="mb-3">
                <label for="password" class="form-label">كلمة المرور</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!-- تأكيد كلمة المرور -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            <!-- الأدوار -->
            <div class="mb-3">
                <label for="roles" class="form-label">الأدوار</label>
                <select class="form-select" id="roles" name="roles[]" multiple required>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">حفظ</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
@endsection
