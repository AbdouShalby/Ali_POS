@extends('layouts.app')

@section('title', '- ' . __('products.all_products'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('products.all_products') }}</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('products.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('products.all_products') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="table-responsive">
                        <form action="{{ route('products.index') }}" method="GET" class="d-flex flex-wrap">
                            <div style="min-width: 100%; overflow-x: auto;">
                                <div class="d-flex flex-nowrap">
                                    <input type="text" name="search" class="form-control form-control-solid w-250px ps-12 me-3" placeholder="{{ __('products.search_by_name') }}" value="{{ request('search') }}" data-kt-ecommerce-product-filter="search"/>

                                    <input type="text" name="barcode" class="form-control form-control-solid w-150px me-3" placeholder="{{ __('products.barcode') }}" value="{{ request('barcode') }}"/>

                                    <input type="number" name="selling_price" class="form-control form-control-solid w-150px me-3" placeholder="{{ __('products.selling_price') }}" value="{{ request('selling_price') }}" step="0.01"/>

                                    <div class="w-100 mw-150px me-3">
                                        <select name="category" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('products.category') }}">
                                            <option value="0">{{ __('products.all_categories') }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="w-100 mw-150px me-3">
                                        <select name="brand" class="form-select form-select-solid" data-control="select2" data-placeholder="{{ __('products.brand') }}">
                                            <option value="0">{{ __('products.all_brands') }}</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success ms-3">{{ __('products.search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">{{ __('products.add_product') }}</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                            <thead>
                            <tr class="text-start fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">{{ __('products.name') }}</th>
                                <th class="min-w-100px text-start">{{ __('products.barcode') }}</th>
                                <th class="min-w-100px text-start">{{ __('products.category') }}</th>
                                <th class="min-w-100px text-start">{{ __('products.brand') }}</th>
                                <th class="min-w-100px text-start">{{ __('products.selling_price') }}</th>
                                <th class="min-w-100px text-start">{{ __('products.lowest_price_for_sale') }}</th>
                                <th class="min-w-100px text-start">{{ __('products.device') }}</th>
                                <th class="min-w-100px text-start">{{ __('products.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            @forelse($products as $product)
                                <tr>
                                    <td><a href="{{ route('products.show', $product->id) }}" class="text-gray-800 text-hover-primary">{{ $product->name }}</a></td>
                                    <td class="text-start">{{ $product->barcode }}</td>
                                    <td class="text-start">{{ $product->category->name ?? __('products.undefined') }}</td>
                                    <td class="text-start">{{ $product->brand->name ?? __('products.undefined') }}</td>
                                    <td class="text-start">{{ number_format($product->price, 2) }}</td>
                                    <td class="text-start">{{ number_format($product->min_sale_price, 2) }}</td>
                                    <td class="text-start">{{ $product->mobileDetail ? __('products.yes') : __('products.no') }}</td>
                                    <td class="text-start">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary" type="button" id="actionDropdown{{ $product->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ki-solid ki-abstract-14"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $product->id }}">
                                                <li><a class="dropdown-item text-info" href="{{ route('products.show', $product->id) }}">{{ __('products.show') }}</a></li>
                                                <li><a class="dropdown-item text-success" href="{{ route('products.edit', $product->id) }}">{{ __('products.edit') }}</a></li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger" onclick="deleteConfirmation(event, this)">
                                                        {{ __('products.delete') }}
                                                    </button>
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </li>
                                                @if($product->mobileDetail)
                                                    <li><button class="dropdown-item text-bg-dark" type="button" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $product->id }}">{{ __('products.device_details') }}</button></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                @if($product->mobileDetail)
                                    <div class="modal fade" id="detailsModal{{ $product->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $product->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailsModalLabel{{ $product->id }}">{{ __('products.device_details') }} - {{ $product->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul>
                                                        <li><strong>{{ __('products.color') }}:</strong> {{ $product->mobileDetail->color }}</li>
                                                        <li><strong>{{ __('products.storage') }}:</strong> {{ $product->mobileDetail->storage }}</li>
                                                        <li><strong>{{ __('products.battery_health') }}:</strong> {{ $product->mobileDetail->battery_health }}%</li>
                                                        <li><strong>{{ __('products.ram') }}:</strong> {{ $product->mobileDetail->ram }}</li>
                                                        <li><strong>{{ __('products.gpu') }}:</strong> {{ $product->mobileDetail->gpu }}</li>
                                                        <li><strong>{{ __('products.cpu') }}:</strong> {{ $product->mobileDetail->cpu }}</li>
                                                        <li><strong>{{ __('products.condition') }}:</strong> {{ $product->mobileDetail->condition }}</li>
                                                        <li><strong>{{ __('products.description') }}:</strong> {{ $product->mobileDetail->device_description }}</li>
                                                        <li><strong>{{ __('products.with_box') }}:</strong> {{ $product->mobileDetail->has_box ? __('products.yes') : __('products.no') }}</li>
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('products.close') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">{{ __('products.no_products_found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            function deleteConfirmation(event, button) {
                event.preventDefault();

                Swal.fire({
                    title: "{{ __('products.are_you_sure') }}",
                    text: "{{ __('products.delete_confirmation_message') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "{{ __('products.yes_delete') }}",
                    cancelButtonText: "{{ __('products.cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.nextElementSibling.submit();
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

        <script>
            @if(session('success'))
            toastr.success("{{ session('success') }}");
            @endif

            @if(session('error'))
            toastr.error("{{ session('error') }}");
            @endif

            @if(session('info'))
            toastr.info("{{ session('info') }}");
            @endif

            @if(session('warning'))
            toastr.warning("{{ session('warning') }}");
            @endif
        </script>
    @endsection
@endsection
