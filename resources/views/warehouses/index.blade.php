@extends('layouts.app')

@section('title', '- ' . __('warehouses.all_warehouses'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('warehouses.all_warehouses') }}</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('warehouses.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('warehouses.all_warehouses') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <a href="{{ route('warehouses.create') }}" class="btn btn-primary">{{ __('warehouses.add_warehouse') }}</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                            <thead>
                            <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">{{ __('warehouses.name') }}</th>
                                <th class="min-w-100px text-start">{{ __('warehouses.location') }}</th>
                                <th class="min-w-100px text-start">{{ __('warehouses.description') }}</th>
                                <th class="min-w-100px text-start">{{ __('warehouses.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @forelse($warehouses as $warehouse)
                                <tr>
                                    <td><a href="{{ route('warehouses.show', $warehouse->id) }}" class="text-gray-800 text-hover-primary">{{ $warehouse->name }}</a></td>
                                    <td class="text-start">{{ $warehouse->location }}</td>
                                    <td class="text-start">{{ $warehouse->description }}</td>
                                    <td class="text-start">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary" type="button" id="actionDropdown{{ $warehouse->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ki-solid ki-abstract-14"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $warehouse->id }}">
                                                <li><a class="dropdown-item text-info" href="{{ route('warehouses.show', $warehouse->id) }}">{{ __('warehouses.show') }}</a></li>
                                                <li><a class="dropdown-item text-success" href="{{ route('warehouses.edit', $warehouse->id) }}">{{ __('warehouses.edit') }}</a></li>
                                                <li>
                                                    <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">{{ __('warehouses.delete') }}</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">{{ __('warehouses.no_warehouses_found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $warehouses->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
