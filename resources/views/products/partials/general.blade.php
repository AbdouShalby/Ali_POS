<div class="d-flex flex-column gap-5">
    <div class="card card-flush py-4">
        <div class="card-header">
            <div class="card-title">
                <h2>{{ __('products.general') }}</h2>
            </div>
        </div>
        <div class="card-body row">
            <!-- Name -->
            <div class="mb-5 col-md-6">
                <label class="form-label">{{ __('products.name') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <!-- Barcode -->
            <div class="mb-5 col-md-6">
                <label class="form-label">{{ __('products.barcode') }}</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="barcode" name="barcode" value="{{ old('barcode', $product->barcode) }}" readonly>
                    <button type="button" class="btn btn-primary" id="generateBarcode">{{ __('products.generate') }}</button>
                </div>
            </div>

            <!-- Stock -->
            <div class="mb-5 col-md-6">
                <label class="form-label">{{ __('products.stock') }}</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>
            </div>

            <!-- Stock Alert -->
            <div class="mb-5 col-md-6">
                <label class="form-label">{{ __('products.stock_alert') }}</label>
                <input type="number" class="form-control" id="stock_alert" name="stock_alert" value="{{ old('stock_alert', $product->stock_alert) }}" required>
            </div>

            <!-- Warehouse -->
            <div class="card card-flush py-4 my-5">
                <div class="card-header">
                    <h2>{{ __('products.warehouse_stock') }}</h2>
                </div>
                <div class="card-body row pt-0">
                    @foreach($warehouses as $warehouse)
                        <div class="mb-10 col-md-4">
                            <label class="form-label">{{ $warehouse->name }}</label>
                            <input type="number" class="form-control mb-2" name="warehouses[{{ $warehouse->id }}]"
                                   value="{{ old('warehouses.' . $warehouse->id, $product->warehouses->find($warehouse->id)->pivot->stock ?? 0) }}"
                                   placeholder="{{ __('products.stock_in_warehouse') }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Cost -->
            <div class="mb-5 col-md-3">
                <label class="form-label">{{ __('products.cost') }}</label>
                <input type="number" class="form-control" id="cost" name="cost" value="{{ old('cost', $product->cost) }}" required>
            </div>

            <!-- Price -->
            <div class="mb-5 col-md-3">
                <label class="form-label">{{ __('products.price') }}</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
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
                    <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail my-3 d-block m-auto" style="max-width: 150px;">
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
