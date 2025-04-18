@extends('layouts.app')

@section('title', '- ' . __('suppliers.add_supplier'))

@section('content')
    <!-- Toolbar -->
    <div class="app-toolbar py-3 py-lg-6">
        <div class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('suppliers.add_supplier') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('suppliers.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('suppliers.index') }}" class="text-muted text-hover-primary">{{ __('suppliers.all_suppliers') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('suppliers.add_supplier') }}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left me-2"></i>
                    {{ __('suppliers.back_to_list') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="app-content flex-column-fluid">
        <div class="app-container container-xxl">
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                    <i class="bi bi-exclamation-circle fs-2hx text-danger me-4"></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-danger">{{ __('suppliers.error') }}</h4>
                        <ul class="list-unstyled">
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

            <form id="kt_supplier_create_form" action="{{ route('suppliers.store') }}" method="POST" class="form">
                @csrf
                
                <!-- Basic Info Card -->
                <div class="card card-flush mb-7">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>{{ __('suppliers.basic_information') }}</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 mb-7">
                                <label class="required form-label">{{ __('suppliers.name') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person fs-4"></i>
                                    </span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name') }}" required
                                           placeholder="{{ __('suppliers.name') }}" />
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-7">
                                <label class="form-label">{{ __('suppliers.email') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope fs-4"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}"
                                           placeholder="{{ __('suppliers.email') }}" />
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-7">
                                <label class="form-label">{{ __('suppliers.phone') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-telephone fs-4"></i>
                                    </span>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           name="phone" value="{{ old('phone') }}"
                                           placeholder="{{ __('suppliers.phone') }}" />
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-md-6 mb-7">
                                <label class="form-label">{{ __('suppliers.address') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-geo-alt fs-4"></i>
                                    </span>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              name="address" rows="1"
                                              placeholder="{{ __('suppliers.address') }}">{{ old('address') }}</textarea>
                                </div>
                                @error('address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="col-12">
                                <label class="form-label">{{ __('suppliers.notes') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-sticky fs-4"></i>
                                    </span>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              name="notes" rows="3"
                                              placeholder="{{ __('suppliers.notes') }}">{{ old('notes') }}</textarea>
                                </div>
                                @error('notes')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('suppliers.index') }}" class="btn btn-light">
                        <i class="bi bi-x me-2"></i>
                        {{ __('suppliers.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check me-2"></i>
                        {{ __('suppliers.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Form Validation
    var form = document.getElementById('kt_supplier_create_form');
    var validation = FormValidation.formValidation(form, {
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: '{{ __("suppliers.name_required") }}'
                    }
                }
            },
            email: {
                validators: {
                    emailAddress: {
                        message: '{{ __("suppliers.email_invalid") }}'
                    }
                }
            },
            phone: {
                validators: {
                    regexp: {
                        regexp: /^[0-9\+\-\(\)\s]*$/,
                        message: '{{ __("suppliers.phone_invalid") }}'
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.mb-7',
                eleInvalidClass: '',
                eleValidClass: ''
            })
        }
    });
</script>
@endpush
