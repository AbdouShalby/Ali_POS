@extends('layouts.app')

@section('title', '- ' . __('Cryptocurrency Gateways'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('crypto_gateways.cryptocurrency_gateways') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('crypto_gateways.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('crypto_gateways.cryptocurrency_gateways') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center p-5 mb-5">
                    <span class="svg-icon svg-icon-2hx svg-icon-success me-3">
                        <i class="bi bi-check-circle-fill fs-2"></i>
                    </span>
                    <div class="d-flex flex-column">
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <h2 class="card-title">{{ __('crypto_gateways.gateway_list') }}</h2>
                    <div class="card-toolbar">
                        <a href="{{ route('crypto_gateways.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> {{ __('crypto_gateways.add_new_gateway') }}
                        </a>
                    </div>
                </div>
                <div class="card-body py-4">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase">
                                <th>{{ __('crypto_gateways.name') }}</th>
                                <th>{{ __('crypto_gateways.balance') }}</th>
                                <th class="text-center">{{ __('crypto_gateways.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @foreach($gateways as $gateway)
                                <tr>
                                    <td>{{ $gateway->name }}</td>
                                    <td>{{ number_format($gateway->balance, 8) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('crypto_transactions.create', $gateway->id) }}" class="btn btn-sm btn-success mx-1">
                                            <i class="bi bi-currency-exchange"></i> {{ __('crypto_gateways.buy_sell') }}
                                        </a>
                                        <a href="{{ route('crypto_gateways.edit', $gateway->id) }}" class="btn btn-sm btn-warning mx-1">
                                            <i class="bi bi-pencil"></i> {{ __('crypto_gateways.edit') }}
                                        </a>
                                        <form action="{{ route('crypto_gateways.destroy', $gateway->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger mx-1" onclick="return confirm('{{ __('crypto_gateways.confirm_delete') }}')">
                                                <i class="bi bi-trash"></i> {{ __('crypto_gateways.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
