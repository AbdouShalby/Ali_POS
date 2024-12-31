@extends('layouts.app')

@section('title', '- ' . __('suppliers.all_suppliers'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('suppliers.all_suppliers') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('suppliers.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('suppliers.all_suppliers') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-5">
                <form action="{{ route('suppliers.index') }}" method="GET" class="d-flex align-items-center w-50">
                    <input type="text" name="search" class="form-control me-3" placeholder="{{ __('suppliers.search_placeholder') }}" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary d-flex align-items-center">
                        <i class="bi bi-search me-2"></i> {{ __('suppliers.search') }}
                    </button>
                </form>
                <a href="{{ route('suppliers.create') }}" class="btn btn-primary d-flex align-items-center">
                    <i class="bi bi-plus-circle me-2"></i> {{ __('suppliers.add_new_supplier') }}
                </a>
            </div>

            <div class="card card-flush">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="card-title">{{ __('suppliers.supplier_list') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead class="table-light">
                            <tr>
                                <th>{{ __('suppliers.name') }}</th>
                                <th>{{ __('suppliers.email') }}</th>
                                <th>{{ __('suppliers.phone') }}</th>
                                <th>{{ __('suppliers.address') }}</th>
                                <th class="text-center">{{ __('suppliers.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($suppliers as $supplier)
                                <tr>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->email ?? __('suppliers.not_available') }}</td>
                                    <td>{{ $supplier->phone ?? __('suppliers.not_available') }}</td>
                                    <td>{{ $supplier->address ?? __('suppliers.not_available') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-sm btn-info me-1">
                                            <i class="bi bi-eye"></i> {{ __('suppliers.view') }}
                                        </a>
                                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil-square"></i> {{ __('suppliers.edit') }}
                                        </a>
                                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('suppliers.confirm_delete') }}')">
                                                <i class="bi bi-trash"></i> {{ __('suppliers.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">{{ __('suppliers.no_suppliers_found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $suppliers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
