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
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <h2 class="card-title">{{ __('categories.category_list') }}</h2>
                    <div class="card-toolbar">
                        <form action="{{ route('categories.index') }}" method="GET" class="d-flex align-items-center">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('categories.search_by_name') }}" value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary d-flex align-items-center">
                                    <i class="bi bi-search me-2"></i> {{ __('categories.search') }}
                                </button>
                            </div>
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
                                            <button type="button" class="btn btn-danger" onclick="deleteConfirmation(event, this)">
                                                <i class="bi bi-trash"></i>  {{ __('categories.delete') }}
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

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function deleteConfirmation(event, button) {
                event.preventDefault();

                Swal.fire({
                    title: "{{ __('brands.confirm_delete') }}",
                    text: "{{ __('products.delete_confirmation_message') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "{{ __('products.yes_delete') }}",
                    cancelButtonText: "{{ __('products.cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    }
                });
            }

            @if(session('success'))
            Swal.fire("{{ __('products.success') }}", "{{ session('success') }}", "success");
            @endif

            @if(session('error'))
            Swal.fire("{{ __('products.error') }}", "{{ session('error') }}", "error");
            @endif
        </script>
    @endsection

@endsection
