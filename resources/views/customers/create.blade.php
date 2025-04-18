@extends('layouts.app')

@section('title', '- ' . __('customers.add_customer'))

@section('content')
    <!-- Toolbar -->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('customers.add_customer') }}
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
                    <li class="breadcrumb-item text-muted">{{ __('customers.add_customer') }}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('customers.index') }}" class="btn btn-sm btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    {{ __('customers.back_to_list') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                        <i class="bi bi-exclamation-triangle-fill fs-2"></i>
                    </span>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-danger">{{ __('customers.error') }}</h4>
                        <ul class="list-unstyled mb-0">
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

            <form action="{{ route('customers.store') }}" method="POST" id="kt_create_customer_form" class="form">
                @csrf
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('customers.basic_information') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-9">
                            <!-- Name Field -->
                            <div class="col-md-6">
                                <label class="required form-label fw-bold">{{ __('customers.name') }}</label>
                                <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid @enderror" 
                                    placeholder="{{ __('customers.name') }}" value="{{ old('name') }}" required />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Field -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('customers.phone') }}</label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="text" name="phone" class="form-control form-control-solid @error('phone') is-invalid @enderror" 
                                        placeholder="{{ __('customers.phone') }}" value="{{ old('phone') }}" />
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">{{ __('customers.email') }}</label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control form-control-solid @error('email') is-invalid @enderror" 
                                        placeholder="{{ __('customers.email') }}" value="{{ old('email') }}" />
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address Field -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">{{ __('customers.address') }}</label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <textarea name="address" class="form-control form-control-solid @error('address') is-invalid @enderror" 
                                        rows="3" placeholder="{{ __('customers.address') }}">{{ old('address') }}</textarea>
                                </div>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Notes Field -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">{{ __('customers.notes') }}</label>
                                <div class="input-group input-group-solid">
                                    <span class="input-group-text"><i class="bi bi-sticky"></i></span>
                                    <textarea name="notes" class="form-control form-control-solid @error('notes') is-invalid @enderror" 
                                        rows="3" placeholder="{{ __('customers.notes') }}">{{ old('notes') }}</textarea>
                                </div>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6">
                        <a href="{{ route('customers.index') }}" class="btn btn-light btn-active-light-primary me-2">
                            {{ __('customers.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">
                                <i class="bi bi-check-circle me-2"></i>{{ __('customers.save') }}
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Form validation
        var form = document.getElementById('kt_create_customer_form');
        var validator = FormValidation.formValidation(form, {
            fields: {
                'name': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("customers.name_required") }}'
                        }
                    }
                },
                'email': {
                    validators: {
                        emailAddress: {
                            message: '{{ __("customers.email_invalid") }}'
                        }
                    }
                },
                'phone': {
                    validators: {
                        regexp: {
                            regexp: /^[0-9\s\-\+\(\)]+$/,
                            message: '{{ __("customers.phone_invalid") }}'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.row > div',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        });
    </script>
@endpush
