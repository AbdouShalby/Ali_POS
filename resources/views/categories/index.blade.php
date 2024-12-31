@extends('layouts.app')

@section('title', '- ' . __('categories.all_categories'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('categories.all_categories') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('categories.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('categories.all_categories') }}</li>
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
                    <h2 class="card-title">{{ __('categories.category_list') }}</h2>
                    <div class="card-toolbar">
                        <form action="{{ route('categories.index') }}" method="GET" class="d-flex align-items-center">
                            <div class="input-group me-3">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('categories.search_by_name') }}" value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                {{ __('categories.search') }}
                            </button>
                        </form>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary ms-3">
                            <i class="bi bi-plus-circle"></i> {{ __('categories.add_new_category') }}
                        </a>
                    </div>
                </div>
                <div class="card-body py-4">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr class="text-gray-400 fw-bold fs-7 text-uppercase">
                                <th>{{ __('categories.name') }}</th>
                                <th>{{ __('categories.description') }}</th>
                                <th class="text-center">{{ __('categories.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ Str::limit($category->description, 50) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info btn-sm mx-1">
                                            <i class="bi bi-eye"></i> {{ __('categories.view') }}
                                        </a>
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm mx-1">
                                            <i class="bi bi-pencil"></i> {{ __('categories.edit') }}
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirm('{{ __('categories.confirm_delete') }}')">
                                                <i class="bi bi-trash"></i> {{ __('categories.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">{{ __('categories.no_categories_found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
