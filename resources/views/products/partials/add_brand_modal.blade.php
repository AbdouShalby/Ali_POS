<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBrandModalLabel">{{ __('products.add_new_brand') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBrandForm">
                    @csrf
                    <div class="mb-3">
                        <label for="brand_name_modal" class="form-label">{{ __('products.brand_name') }}</label> {{-- Changed id to avoid conflict --}}
                        <input type="text" class="form-control" id="brand_name_modal" name="name" required>
                        <small id="brand-error-modal" class="text-danger d-none">{{ __('products.brand_already_exists') }}</small>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('products.add') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
