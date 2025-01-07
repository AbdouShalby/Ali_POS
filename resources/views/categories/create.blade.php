@extends('layouts.app')

@section('title', '- ' . __('categories.create_category'))

@section('content')
    <!-- Toolbar -->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('categories.create_category') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('categories.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('categories.index') }}" class="text-muted text-hover-primary">{{ __('categories.all_categories') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('categories.create_category') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!-- Error Alert -->
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                        <i class="bi bi-exclamation-triangle-fill fs-2"></i>
                    </span>
                    <div>
                        <h4 class="alert-heading fw-bold">{{ __('categories.error') }}</h4>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Create Form -->
            <div class="card card-flush py-4">
                <div class="card-header">
                    <h2 class="card-title">{{ __('categories.create_category') }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <!-- Name Field -->
                        <div class="mb-10">
                            <label for="name" class="form-label fw-bold">{{ __('categories.name') }}</label>
                            <input
                                type="text"
                                class="form-control form-control-solid"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required>
                        </div>

                        <!-- Description Field -->
                        <div class="mb-10">
                            <label for="description" class="form-label fw-bold">{{ __('categories.description') }}</label>
                            <textarea
                                class="form-control form-control-solid"
                                id="description"
                                name="description"
                                rows="3">{{ old('description') }}</textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-3">
                                <i class="bi bi-check-circle"></i> {{ __('categories.save') }}
                            </button>
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> {{ __('categories.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
