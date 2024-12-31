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
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-5">
                <form action="{{ route('customers.index') }}" method="GET" class="d-flex align-items-center w-50">
                    <input type="text" name="search" class="form-control me-3"
                           placeholder="{{ __('customers.search_placeholder') }}"
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">{{ __('customers.search') }}</button>
                </form>
                <a href="{{ route('customers.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> {{ __('customers.add_new_customer') }}
                </a>
            </div>

            <div class="card card-flush">
                <div class="card-header">
                    <h2>{{ __('customers.customer_list') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr>
                                <th>{{ __('customers.name') }}</th>
                                <th>{{ __('customers.email') }}</th>
                                <th>{{ __('customers.phone') }}</th>
                                <th>{{ __('customers.address') }}</th>
                                <th class="text-end">{{ __('customers.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($customers as $customer)
                                <tr>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email ?? __('customers.not_available') }}</td>
                                    <td>{{ $customer->phone ?? __('customers.not_available') }}</td>
                                    <td>{{ $customer->address ?? __('customers.not_available') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> {{ __('customers.view') }}
                                        </a>
                                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i> {{ __('customers.edit') }}
                                        </a>
                                        <form action="{{ route('customers.destroy', $customer->id) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('{{ __('customers.confirm_delete') }}')">
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
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
