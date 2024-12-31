@extends('layouts.app')

@section('title', '- ' . __('brands.edit_brand'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('brands.edit_brand') }}: {{ $brand->name }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('brands.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('brands.index') }}" class="text-muted text-hover-primary">{{ __('brands.all_brands') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('brands.edit_brand') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ __('brands.error') }}</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('brands.update', $brand->id) }}" method="POST" class="form">
                @csrf
                @method('PUT')
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ __('brands.edit_brand') }}</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-10">
                            <label class="form-label">{{ __('brands.name') }}</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $brand->name) }}" required>
                        </div>
                        <div class="mb-10">
                            <label class="form-label">{{ __('brands.description') }}</label>
                            <textarea class="form-control" name="description" rows="3">{{ old('description', $brand->description) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">{{ __('brands.update') }}</button>
                    <a href="{{ route('brands.index') }}" class="btn btn-secondary ms-3">{{ __('brands.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
