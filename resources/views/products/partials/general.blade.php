<div class="d-flex flex-column gap-7 gap-lg-12">
    <div class="card card-flush py-4">
        <div class="card-header mb-5">
            <div class="card-title">
                <h2>{{ __('products.general') }}</h2>
            </div>
            <div class="card-title">
                <h2 class="me-5">{{ __('products.is_device') }}</h2>
                <input type="checkbox" class="form-check-input me-2" id="is_mobile" name="is_mobile" {{ $product->mobileDetail ? 'checked' : '' }}>
                <label class="form-check-label" for="is_mobile">{{ __('products.yes') }}</label>
            </div>
        </div>
        <div class="card-body row pt-0">
            <!-- Name -->
            <div class="mb-10 col-md-5">
                <label class="form-label">{{ __('products.name') }}</label>
                <input type="text" class="form-control mb-2" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            </div>
            <!-- Barcode -->
            <div class="mb-10 col-md-7">
                <label class="form-label">{{ __('products.barcode') }}</label>
                <div class="input-group d-flex align-items-center">
                    <input type="text" class="form-control mb-2" id="barcode" name="barcode" value="{{ old('barcode', $product->barcode) }}" readonly required>
                </div>
            </div>
            <!-- Warehouses -->
            <div class="card py-10 mb-10">
                <div class="card-header">
                    <h4>{{ __('products.assign_stock_to_warehouses') }}</h4>
                </div>
                <div class="card-body" id="warehouse-container">
                    @foreach($product->warehouses as $index => $warehouse)
                        <div class="input-group mb-2 warehouse-entry">
                            <select class="form-select" name="warehouses[{{ $index }}][id]" required>
                                <option value="">{{ __('products.select_warehouse') }}</option>
                                @foreach($warehouses as $availableWarehouse)
                                    <option value="{{ $availableWarehouse->id }}" {{ $warehouse->id == $availableWarehouse->id ? 'selected' : '' }}>
                                        {{ $availableWarehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" class="form-control" name="warehouses[{{ $index }}][stock]" placeholder="{{ __('products.stock') }}" value="{{ $warehouse->pivot->stock }}" required>
                            <input type="number" class="form-control" name="warehouses[{{ $index }}][stock_alert]" placeholder="{{ __('products.stock_alert') }}" value="{{ $warehouse->pivot->stock_alert }}" required>
                            <button type="button" class="btn btn-danger remove-warehouse">{{ __('products.remove') }}</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-warehouse" class="btn btn-primary">{{ __('products.add_warehouse') }}</button>
            </div>
            <!-- Cost -->
            <div class="mb-10 col-md-3">
                <label class="form-label">{{ __('products.cost') }}</label>
                <input type="number" class="form-control mb-2" id="cost" name="cost" value="{{ old('cost', $product->cost) }}" step="0.01" required>
            </div>
            <!-- Price -->
            <div class="mb-10 col-md-3">
                <label class="form-label">{{ __('products.price') }}</label>
                <input type="number" class="form-control mb-2" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" required>
            </div>
            <!-- Wholesale Price -->
            <div class="mb-5 col-md-3">
                <label class="form-label">{{ __('products.wholesale_price') }}</label>
                <input type="number" class="form-control" id="wholesale_price" name="wholesale_price" value="{{ old('wholesale_price', $product->wholesale_price) }}" required>
            </div>
            <!-- Minimum Sale Price -->
            <div class="mb-5 col-md-3">
                <label class="form-label">{{ __('products.lowest_price_for_sale') }}</label>
                <input type="number" class="form-control" id="min_sale_price" name="min_sale_price" value="{{ old('min_sale_price', $product->min_sale_price) }}" required>
            </div>
            <!-- Description -->
            <div class="mb-5 col-md-12">
                <label class="form-label">{{ __('products.description') }}</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $product->description) }}</textarea>
            </div>
            <!-- Image -->
            <div class="mb-5 col-md-4">
                <label class="form-label">{{ __('products.image') }}</label>
                <input type="file" class="form-control" id="image" name="image">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail my-3 d-block m-auto" style="max-width: 150px;">
                @endif
            </div>
            <div class="mb-5 col-md-4">
                <label class="form-label">{{ __('products.category') }}</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">{{ __('products.choose_category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-5 col-md-4">
                <label class="form-label">{{ __('products.brand') }}</label>
                <select class="form-select" id="brand_id" name="brand_id" required>
                    <option value="">{{ __('products.choose_brand') }}</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
