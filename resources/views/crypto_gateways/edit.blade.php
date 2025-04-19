@extends('layouts.app')

@section('title', __('crypto_gateways.edit_gateway'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('crypto_gateways.edit_gateway') }}: {{ $gateway->name }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('crypto_gateways.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('crypto_gateways.index') }}" class="text-muted text-hover-primary">{{ __('crypto_gateways.cryptocurrency_gateways') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('crypto_gateways.edit_gateway') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                        <i class="bi bi-exclamation-triangle-fill fs-2"></i>
                    </span>
                    <div>
                        <h4 class="mb-1 text-danger">{{ __('crypto_gateways.error') }}</h4>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                        <i class="bi bi-x fs-1 text-danger"></i>
                    </button>
                </div>
            @endif

            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-title">
                        <h2 class="mb-0">{{ __('crypto_gateways.edit_gateway') }}</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('crypto_gateways.update', $gateway->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-10">
                            <label class="required fw-semibold fs-6 mb-2">{{ __('crypto_gateways.name') }}</label>
                            <input type="text" 
                                   class="form-control form-control-solid @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name', $gateway->name) }}" 
                                   required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('crypto_gateways.index') }}" class="btn btn-light me-3">
                                <i class="bi bi-arrow-left"></i>
                                {{ __('crypto_gateways.cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i>
                                {{ __('crypto_gateways.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
