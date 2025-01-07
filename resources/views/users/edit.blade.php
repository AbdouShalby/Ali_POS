@extends('layouts.app')

@section('title', '- ' . __('Edit User'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('users.edit_user') }}: {{ $user->name }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('users.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('users.index') }}" class="text-muted text-hover-primary">{{ __('users.management') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('users.edit_user') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if($errors->any())
                <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-4">
                        <i class="bi bi-exclamation-triangle-fill fs-2"></i>
                    </span>
                    <div>
                        <h4 class="alert-heading fw-bold">{{ __('users.error') }}</h4>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card card-flush py-4">
                <div class="card-header">
                    <h2 class="card-title">{{ __('users.edit_user') }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Name Field -->
                        <div class="mb-10">
                            <label for="name" class="form-label fw-bold">{{ __('users.name') }}</label>
                            <input
                                type="text"
                                class="form-control form-control-solid"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-10">
                            <label for="email" class="form-label fw-bold">{{ __('users.email') }}</label>
                            <input
                                type="email"
                                class="form-control form-control-solid"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-10">
                            <label for="password" class="form-label fw-bold">{{ __('users.password') }} ({{ __('users.leave_blank') }})</label>
                            <input
                                type="password"
                                class="form-control form-control-solid"
                                id="password"
                                name="password">
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-10">
                            <label for="password_confirmation" class="form-label fw-bold">{{ __('users.confirm_password') }}</label>
                            <input
                                type="password"
                                class="form-control form-control-solid"
                                id="password_confirmation"
                                name="password_confirmation">
                        </div>

                        <!-- Roles Field -->
                        <div class="mb-10">
                            <label for="roles" class="form-label fw-bold">{{ __('users.roles') }}</label>
                            <select
                                class="form-control form-control-solid"
                                id="roles"
                                name="roles[]"
                                multiple
                                required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ in_array($role->name, $user->getRoleNames()->toArray()) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-3">
                                <i class="bi bi-check-circle"></i> {{ __('users.update') }}
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> {{ __('users.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
