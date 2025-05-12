<div class="modal fade" id="printOptionsModal" tabindex="-1" aria-labelledby="printOptionsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printOptionsLabel">{{ __('products.print_options') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="paperSizeModal" class="form-label">{{ __('products.select_labels_per_sheet') }}</label> {{-- Changed id --}}
                    <select class="form-select" id="paperSizeModal" required>
                        <option value="40">{{ __('products.40_per_sheet') }}</option>
                        <option value="30">{{ __('products.30_per_sheet') }}</option>
                        <option value="24">{{ __('products.24_per_sheet') }}</option>
                        <option value="20">{{ __('products.20_per_sheet') }}</option>
                        <option value="18">{{ __('products.18_per_sheet') }}</option>
                        <option value="14">{{ __('products.14_per_sheet') }}</option>
                        <option value="12">{{ __('products.12_per_sheet') }}</option>
                        <option value="10">{{ __('products.10_per_sheet') }}</option>
                        <option value="custom">{{ __('products.custom') }}</option>
                    </select>
                </div>
                <div class="form-group mb-3" id="customLabelCountContainerModal" style="display: none;"> {{-- Changed id --}}
                    <label for="customLabelCountModal" class="form-label">{{ __('products.enter_custom_number_of_labels_per_page_(1-40):') }}</label>
                    <input type="number" id="customLabelCountModal" min="1" max="40" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="labelContentModal" class="form-label">{{ __('products.label_content') }}</label>
                    <input type="text" class="form-control" id="labelContentModal" placeholder="{{ __('products.enter_content_to_appear_on_the_label') }}" value="{{ __('products.product_name_price_and_barcode') }}" disabled>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('products.cancel') }}</button>
                <button type="button" class="btn btn-primary" id="confirmPrintModal">{{ __('products.print') }}</button> {{-- Changed id --}}
            </div>
        </div>
    </div>
</div>
