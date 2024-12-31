@extends('layouts.app')

@section('title', '- ' . __('brands.all_brands'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('brands.all_brands') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('brands.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('brands.all_brands') }}</li>
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

            <div class="card card-flush">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ __('brands.brand_list') }}</h2>
                    </div>
                    <div class="card-toolbar">
                        <form action="{{ route('brands.index') }}" method="GET" class="d-flex align-items-center">
                            <input type="text" name="search" class="form-control form-control-solid me-3" placeholder="{{ __('brands.search_by_name') }}" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">{{ __('brands.search') }}</button>
                        </form>
                        <a href="{{ route('brands.create') }}" class="btn btn-primary ms-3">
                            <i class="bi bi-plus-circle"></i> {{ __('brands.add_new_brand') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr>
                                <th>{{ __('brands.name') }}</th>
                                <th>{{ __('brands.description') }}</th>
                                <th class="text-end">{{ __('brands.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($brands as $brand)
                                <tr>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ Str::limit($brand->description, 50) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> {{ __('brands.view') }}
                                        </a>
                                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i> {{ __('brands.edit') }}
                                        </a>
                                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('brands.confirm_delete') }}')">
                                                <i class="bi bi-trash"></i> {{ __('brands.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">{{ __('brands.no_brands_found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        {{ $brands->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
