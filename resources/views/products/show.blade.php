@extends('layouts.app')

@section('title', '- ' . __('Product Details'))

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('All Products') }}</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('All Products') }}</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ $product->name }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="d-flex justify-content-end">
                <a href="{{ route('products.index') }}" class="btn btn-dark me-5">{{ __('Back') }}</a>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning me-5">{{ __('Edit') }}</a>
            </div>
            <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row">
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                    <div class="card card-flush py-3">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{ __('Image') }}</h2>
                            </div>
                        </div>
                        <div class="card-body text-center pt-0">
                            <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                @if(empty($product->image))
                                    <div class="image-input-wrapper w-150px h-150px" id="noImageLottie"></div>
                                @else
                                    <div class="image-input-wrapper w-150px h-150px" style="background-image: url({{ asset('images/products/' . $product->image) }})"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($product->barcode)
                        <div class="card card-flush py-3">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ __('Barcode') }}</h2>
                                </div>
                            </div>
                            <div class="card-body text-center pt-0">
                                <div class="d-inline-block mw-150px overflow-hidden text-center">
                                    {!! (new \Picqer\Barcode\BarcodeGeneratorHTML())->getBarcode($product->barcode, \Picqer\Barcode\BarcodeGeneratorHTML::TYPE_CODE_128) !!}
                                </div>
                                <div class="mt-2">
                                    <strong>{{ $product->barcode }}</strong>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card card-flush py-3">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{ __('Category') }}</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <input type="text" class="form-control mb-2" placeholder="{{ __('Empty Name') }}" value="{{ $product->category->name }}" readonly />
                        </div>
                    </div>
                    <div class="card card-flush py-3">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{ __('Brand') }}</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <input type="text" class="form-control mb-2" placeholder="{{ __('Empty Name') }}" value="{{ $product->brand->name }}" readonly />
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_add_product_general">{{ __('General') }}</a>
                        </li>
                        @if($product->mobileDetail && !empty($product->mobileDetail->id))
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_add_product_advanced">{{ __('Device') }}</a>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>General</h2>
                                        </div>
                                    </div>
                                    <div class="card-body row pt-0">
                                        <div class="mb-10 col-md-6">
                                            <label class="form-label">{{ __('Name') }}</label>
                                            <input type="text" class="form-control mb-2" placeholder="{{ __('Empty Name') }}" value="{{ $product->name }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-6">
                                            <label class="form-label">{{ __('Code') }}</label>
                                            <input type="text" class="form-control mb-2" placeholder="{{ __('Empty Code') }}" value="{{ $product->code }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('Cost') }}</label>
                                            <input type="number" class="form-control mb-2" placeholder="{{ __('Empty Cost') }}" value="{{ $product->cost }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('Price') }}</label>
                                            <input type="number" class="form-control mb-2" placeholder="{{ __('Empty Price') }}" value="{{ $product->price }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('Wholesale Price') }}</label>
                                            <input type="number" class="form-control mb-2" placeholder="{{ __('Empty Wholesale Price') }}" value="{{ $product->wholesale_price }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-3">
                                            <label class="form-label">{{ __('Lowest Price For Sale') }}</label>
                                            <input type="number" class="form-control mb-2" placeholder="{{ __('Empty Lowest Price For Sale') }}" value="{{ $product->min_sale_price }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-6">
                                            <label class="form-label">{{ __('Stock') }}</label>
                                            <input type="number" class="form-control mb-2 {{ $product->quantity <= $product->stock_alert ? 'text-warning' : '' }}" placeholder="{{ __('Empty Stock') }}" value="{{ $product->quantity }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-6">
                                            <label class="form-label">{{ __('Stock Alert') }}</label>
                                            <input type="number" class="form-control mb-2" placeholder="{{ __('Empty Stock Alert') }}" value="{{ $product->stock_alert }}" readonly />
                                        </div>
                                        <div class="mb-10 col-md-12">
                                            <label class="form-label">{{ __('Description') }}</label>
                                            <textarea class="form-control mb-2 min-h-100px" placeholder="{{ __('Empty Description') }}" readonly>{{ $product->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($product->mobileDetail && !empty($product->mobileDetail->id))
                            <div class="tab-pane fade" id="kt_ecommerce_add_product_advanced" role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <div class="card card-flush py-4">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>{{ __('Device') }}</h2>
                                            </div>
                                        </div>
                                        <div class="card-body row pt-0">
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('Color') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('Empty Color') }}" value="{{ $product->mobileDetail->color }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('Storage') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('Empty Storage') }}" value="{{ $product->mobileDetail->storage }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('Battery Health') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('Empty Battery Health') }}" value="{{ number_format($product->mobileDetail->battery_health, 0) }}%" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('Ram') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('Empty Ram') }}" value="{{ ($product->mobileDetail->ram) }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('CPU') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('Empty CPU') }}" value="{{ ($product->mobileDetail->cpu) }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('GPU') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('Empty GPU') }}" value="{{ ($product->mobileDetail->gpu) }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('Condition') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('Empty Condition') }}" value="{{ ($product->mobileDetail->condition) }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-3">
                                                <label class="form-label">{{ __('With Box') }}</label>
                                                <input type="text" class="form-control mb-2" placeholder="{{ __('Empty With Box') }}" value="{{ $product->mobileDetail->has_box ? 'Yes' : 'No' }}" readonly />
                                            </div>
                                            <div class="mb-10 col-md-12">
                                                <label class="form-label">{{ __('Device Description') }}</label>
                                                <textarea class="form-control mb-2 min-h-100px" placeholder="{{ __('Empty Device Description') }}" readonly>{{ $product->mobileDetail->device_description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                lottie.loadAnimation({
                    container: document.getElementById('noImageLottie'),
                    renderer: 'svg',
                    loop: true,
                    autoplay: true,
                    path: "{{ asset('media/lottie/no-image.json') }}"
                });
            });
        </script>
    @endsection
@endsection
