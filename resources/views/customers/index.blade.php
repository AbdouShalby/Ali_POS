@extends('layouts.app')

@section('title', '- ' . __('customers.all_customers'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('customers.all_customers') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('customers.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('customers.all_customers') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center p-5 mb-5">
                    <i class="bi bi-check-circle-fill fs-2 text-success me-3"></i>
                    <div>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <h2 class="card-title">{{ __('customers.customer_list') }}</h2>
                    <div class="card-toolbar">
                        <form action="{{ route('customers.index') }}" method="GET" class="d-flex align-items-center">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('customers.search_by_name') }}" value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary d-flex align-items-center">
                                    <i class="bi bi-search me-2"></i> {{ __('customers.search') }}
                                </button>
                            </div>
                        </form>
                        <a href="{{ route('customers.create') }}" class="btn btn-primary ms-3">
                            <i class="bi bi-plus-circle"></i> {{ __('customers.add_new_customer') }}
                        </a>
                    </div>
                </div>
                <div class="card-body py-4">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase">
                                <th>{{ __('customers.name') }}</th>
                                <th>{{ __('customers.email') }}</th>
                                <th>{{ __('customers.phone') }}</th>
                                <th>{{ __('customers.address') }}</th>
                                <th class="text-center">{{ __('customers.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @forelse($customers as $customer)
                                <tr>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email ?? __('customers.not_available') }}</td>
                                    <td>{{ $customer->phone ?? __('customers.not_available') }}</td>
                                    <td>{{ $customer->address ?? __('customers.not_available') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info btn-sm mx-1">
                                            <i class="bi bi-eye"></i> {{ __('customers.view') }}
                                        </a>
                                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm mx-1">
                                            <i class="bi bi-pencil"></i> {{ __('customers.edit') }}
                                        </a>
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirm('{{ __('customers.confirm_delete') }}')">
                                                <i class="bi bi-trash"></i> {{ __('customers.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">{{ __('customers.no_customers_found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
