@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>تعديل البراند</h1>
        <form action="{{ route('brands.update', $brand->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>اسم البراند</label>
                <input type="text" name="name" class="form-control" value="{{ $brand->name }}" required>
            </div>
            <button type="submit" class="btn btn-success">تحديث</button>
        </form>
    </div>
@endsection
