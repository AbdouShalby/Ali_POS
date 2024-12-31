@extends('layouts.app')

@section('title', '- ' . __('customers.edit_customer'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('customers.edit_customer') }}: {{ $customer->name }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('customers.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('customers.index') }}" class="text-muted text-hover-primary">{{ __('customers.all_customers') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('customers.edit_customer') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ __('customers.error') }}</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card card-flush">
                    <div class="card-header">
                        <h2>{{ __('customers.edit_customer_details') }}</h2>
                    </div>
                    <div class="card-body row pt-0">
                        <div class="mb-10 col-md-6">
                            <label for="name" class="form-label">{{ __('customers.name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                        </div>
                        <div class="mb-10 col-md-6">
                            <label for="email" class="form-label">{{ __('customers.email') }}</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $customer->email) }}">
                        </div>
                        <div class="mb-10 col-md-6">
                            <label for="phone" class="form-label">{{ __('customers.phone') }}</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}">
                        </div>
                        <div class="mb-10 col-md-6">
                            <label for="address" class="form-label">{{ __('customers.address') }}</label>
                            <textarea class="form-control" id="address" name="address" rows="2">{{ old('address', $customer->address) }}</textarea>
                        </div>
                        <div class="mb-10 col-md-12">
                            <label for="notes" class="form-label">{{ __('customers.notes') }}</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $customer->notes) }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-3">
                            <i class="bi bi-check-circle"></i> {{ __('customers.update') }}
                        </button>
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> {{ __('customers.cancel') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
