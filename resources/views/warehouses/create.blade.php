@extends('layouts.app')

@section('title', '- ' . __('warehouses.add_warehouse'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('warehouses.add_warehouse') }}</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('warehouses.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('warehouses.add_warehouse') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form action="{{ route('warehouses.store') }}" method="POST" class="form d-flex flex-column flex-lg-row">
                @csrf
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-12">
                    <div class="card card-flush py-4">
                        <div class="card-header mb-5">
                            <div class="card-title">
                                <h2>{{ __('warehouses.add_warehouse') }}</h2>
                            </div>
                        </div>
                        <div class="card-body row pt-0">
                            <div class="mb-10 col-md-6">
                                <label class="form-label">{{ __('warehouses.name') }}</label>
                                <input type="text" class="form-control mb-2" id="name" name="name" required>
                            </div>
                            <div class="mb-10 col-md-6">
                                <label class="form-label">{{ __('warehouses.location') }}</label>
                                <input type="text" class="form-control mb-2" id="location" name="location" required>
                            </div>
                            <div class="mb-10 col-md-12">
                                <label class="form-label">{{ __('warehouses.description') }}</label>
                                <textarea class="form-control mb-2" id="description" name="description" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-3">{{ __('warehouses.save') }}</button>
                        <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">{{ __('warehouses.cancel') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
