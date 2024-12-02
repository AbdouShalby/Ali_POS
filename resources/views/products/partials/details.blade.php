<div class="d-flex flex-column gap-7 gap-lg-10">
    <div class="card card-flush py-4">
        <div class="card-header">
            <div class="card-title">
                <h2>{{ __('products.device_details') }}</h2>
            </div>
        </div>
        <div class="card-body row pt-0">
            <div class="mb-10 col-md-3">
                <label class="form-label">{{ __('products.color') }}</label>
                <input type="text" class="form-control mb-2" id="color" name="color"
                       value="{{ old('color', $mobileDetail->color ?? '') }}">
            </div>
            <div class="mb-10 col-md-3">
                <label class="form-label">{{ __('products.storage') }}</label>
                <input type="text" class="form-control mb-2" id="storage" name="storage"
                       value="{{ old('storage', $mobileDetail->storage ?? '') }}">
            </div>
            <div class="mb-10 col-md-3">
                <label class="form-label">{{ __('products.battery_health') }}</label>
                <input type="number" class="form-control mb-2" id="battery_health" name="battery_health"
                       value="{{ old('battery_health', $mobileDetail->battery_health ?? '') }}">
            </div>
            <div class="mb-10 col-md-3">
                <label class="form-label">{{ __('products.ram') }}</label>
                <input type="text" class="form-control mb-2" id="ram" name="ram"
                       value="{{ old('ram', $mobileDetail->ram ?? '') }}">
            </div>
            <div class="mb-10 col-md-3">
                <label class="form-label">{{ __('products.cpu') }}</label>
                <input type="text" class="form-control mb-2" id="cpu" name="cpu"
                       value="{{ old('cpu', $mobileDetail->cpu ?? '') }}">
            </div>
            <div class="mb-10 col-md-3">
                <label class="form-label">{{ __('products.gpu') }}</label>
                <input type="text" class="form-control mb-2" id="gpu" name="gpu"
                       value="{{ old('gpu', $mobileDetail->gpu ?? '') }}">
            </div>
            <div class="mb-10 col-md-3">
                <label class="form-label">{{ __('products.condition') }}</label>
                <input type="text" class="form-control mb-2" id="condition" name="condition"
                       value="{{ old('condition', $mobileDetail->condition ?? '') }}">
            </div>
            <div class="mb-10 col-md-3">
                <label class="form-label">{{ __('products.with_box') }}</label>
                <select class="form-select mb-2" id="has_box" name="has_box">
                    <option value="1" {{ old('has_box', $mobileDetail->has_box ?? '') == 1 ? 'selected' : '' }}>
                        {{ __('products.yes') }}
                    </option>
                    <option value="0" {{ old('has_box', $mobileDetail->has_box ?? '') == 0 ? 'selected' : '' }}>
                        {{ __('products.no') }}
                    </option>
                </select>
            </div>
            <div class="mb-10 col-md-12">
                <label class="form-label">{{ __('products.device_description') }}</label>
                <textarea class="form-control mb-2 min-h-100px" id="device_description" name="device_description">{{ old('device_description', $mobileDetail->device_description ?? '') }}</textarea>
            </div>

            <div class="mb-5 col-md-4">
                <label class="form-label">{{ __('products.payment_method') }}</label>
                <select class="form-select" id="payment_method" name="payment_method">
                    <option value="">{{ __('products.choose_payment_method') }}</option>
                    <option value="cash" {{ old('payment_method', $mobileDetail->payment_method ?? '') == 'cash' ? 'selected' : '' }}>
                        {{ __('products.cash') }}
                    </option>
                    <option value="credit" {{ old('payment_method', $mobileDetail->payment_method ?? '') == 'credit' ? 'selected' : '' }}>
                        {{ __('products.credit') }}
                    </option>
                </select>
            </div>

            <div class="mb-5 col-md-4">
                <label class="form-label">{{ __('products.scan_id') }}</label>
                <input type="file" class="form-control" id="scan_id" name="scan_id">
            </div>

            <div class="mb-5 col-md-4">
                <label class="form-label">{{ __('products.scan_documents') }}</label>
                <input type="file" class="form-control" id="scan_documents" name="scan_documents">
            </div>

            <div class="mb-5 col-md-4">
                <label class="form-label">{{ __('products.client_type') }}</label>
                <select class="form-select" id="client_type" name="client_type">
                    <option value="">{{ __('products.choose_client_type') }}</option>
                    <option value="customer" {{ old('client_type', $mobileDetail->client_type ?? '') == 'customer' ? 'selected' : '' }}>
                        {{ __('products.customer') }}
                    </option>
                    <option value="supplier" {{ old('client_type', $mobileDetail->client_type ?? '') == 'supplier' ? 'selected' : '' }}>
                        {{ __('products.supplier') }}
                    </option>
                </select>
            </div>
        </div>
    </div>
</div>
