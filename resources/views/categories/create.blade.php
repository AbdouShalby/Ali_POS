@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>إضافة قسم جديد</h1>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>اسم القسم</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">حفظ</button>
        </form>
    </div>
@endsection
