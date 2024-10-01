@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>إضافة براند جديد</h1>
        <form action="{{ route('brands.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>اسم البراند</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">حفظ</button>
        </form>
    </div>
@endsection
