@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>تعديل القسم</h1>
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>اسم القسم</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
            </div>
            <button type="submit" class="btn btn-success">تحديث</button>
        </form>
    </div>
@endsection
