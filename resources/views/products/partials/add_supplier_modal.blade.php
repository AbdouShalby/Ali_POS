<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="addSupplierModalLabel">{{ __('products.add_new_supplier') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addSupplierForm_modal"> {{-- Changed id --}}
                    @csrf
                    <div class="mb-3">
                        <label for="supplier_name_modal" class="form-label fw-bold">{{ __('products.supplier_name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-solid" id="supplier_name_modal" name="name" required>
                        <div class="invalid-feedback" id="supplier-name-error-modal"></div>
                        <div class="form-text">{{ __('products.required_field') }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_phone_modal" class="form-label">{{ __('products.supplier_phone') }}</label>
                        <input type="text" class="form-control form-control-solid" id="supplier_phone_modal" name="phone">
                        <div class="invalid-feedback" id="supplier-phone-error-modal"></div>
                        <div class="form-text">{{ __('products.optional_field') }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_email_modal" class="form-label">{{ __('products.supplier_email') }}</label>
                        <input type="email" class="form-control form-control-solid" id="supplier_email_modal" name="email">
                        <div class="invalid-feedback" id="supplier-email-error-modal"></div>
                        <div class="form-text">{{ __('products.optional_field') }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_address_modal" class="form-label">{{ __('products.supplier_address') }}</label>
                        <input type="text" class="form-control form-control-solid" id="supplier_address_modal" name="address">
                        <div class="invalid-feedback" id="supplier-address-error-modal"></div>
                        <div class="form-text">{{ __('products.optional_field') }}</div>
                    </div>
                    <div id="supplier-form-errors-modal" class="alert alert-danger mt-3 d-none">
                        <ul class="mb-0" id="supplier-errors-list-modal"></ul>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">{{ __('products.cancel') }}</button>
                        <button type="button" id="saveSupplierModal" class="btn btn-primary"> {{-- Changed id --}}
                            <span class="indicator-label">{{ __('products.save') }}</span>
                            <span class="indicator-progress d-none">
                                {{ __('products.please_wait') }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
