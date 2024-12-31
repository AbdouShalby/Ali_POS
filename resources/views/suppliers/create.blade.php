@extends('layouts.app')

@section('title', '- ' . __('suppliers.add_supplier'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('suppliers.add_supplier') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('suppliers.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('suppliers.add_supplier') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-5" role="alert">
                    <strong>{{ __('suppliers.error') }}</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                <div class="card card-flush">
                    <div class="card-header">
                        <h2 class="card-title">{{ __('suppliers.add_supplier_details') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-10 col-md-6">
                                <label for="name" class="form-label">{{ __('suppliers.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-10 col-md-6">
                                <label for="email" class="form-label">{{ __('suppliers.email') }}</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            </div>
                            <div class="mb-10 col-md-6">
                                <label for="phone" class="form-label">{{ __('suppliers.phone') }}</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                            </div>
                            <div class="mb-10 col-md-6">
                                <label for="address" class="form-label">{{ __('suppliers.address') }}</label>
                                <textarea class="form-control" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                            </div>
                            <div class="mb-10 col-md-12">
                                <label for="notes" class="form-label">{{ __('suppliers.notes') }}</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-3 d-flex align-items-center">
                            <i class="bi bi-check-circle me-2"></i>{{ __('suppliers.save') }}
                        </button>
                        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary d-flex align-items-center">
                            <i class="bi bi-arrow-left me-2"></i>{{ __('suppliers.cancel') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
