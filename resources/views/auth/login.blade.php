@extends('layouts.app')

@section('title', __('Login'))

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="row w-100">
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('images/login-background.jpg') }}" alt="Login Image" class="img-fluid rounded-start w-100" style="height: 100%; object-fit: cover;">
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <form action="{{ route('login') }}" method="POST" class="w-75">
                    @csrf
                    <h2 class="text-center mb-4">{{ __('Login') }}</h2>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                        @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        {{ __('Login') }} <i class="bi bi-box-arrow-in-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
@endpush
