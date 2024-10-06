@extends('layouts.app')

@section('title', __('Login'))

@section('content')
    <div class="container">
        <form class="col-md-6" method="POST" action="{{ route('login') }}">
            <h1 class="mb-4 mt-5 pt-5 text-center">{{ __('Login') }}</h1>
            @csrf
            <div class="col-md-9 m-auto">
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
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }} <i class="bi bi-box-arrow-in-right"></i>
                </button>
            </div>
        </form>
        <div class="col-md-6">
            <img class="img-fluid" src="" alt="">
        </div>
    </div>
@endsection
