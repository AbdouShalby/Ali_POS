<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">{{ __('products.add_new_category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    @csrf
                    <div class="mb-3">
                        <label for="category_name_modal" class="form-label">{{ __('products.category_name') }}</label> {{-- Changed id to avoid conflict --}}
                        <input type="text" class="form-control" id="category_name_modal" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('products.add') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
