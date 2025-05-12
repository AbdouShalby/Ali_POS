<div class="modal fade" id="duplicateProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('products.duplicate_product') ?? 'Duplicate Product' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">{{ __('products.search_product') ?? 'Search Product' }}</label>
                    <input type="text" class="form-control" id="productSearchModalInput" placeholder="{{ __('products.search_by_name_barcode') ?? 'Search by name or barcode' }}">
                </div>
                <div id="productSearchResultsModal" class="list-group" style="max-height: 300px; overflow-y: auto;">
                    <!-- Search results will be populated here by JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('products.cancel') }}</button>
                {{-- Button to confirm duplication can be added if needed, or selection itself triggers action --}}
            </div>
        </div>
    </div>
</div>
