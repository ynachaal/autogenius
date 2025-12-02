<div class="py-4">
    <div class="container">
        <div class="card shadow-sm rounded-lg p-4">
            <form action="{{ $action }}" method="POST" id="{{ $formId ?? 'createMenuCategoryForm' }}">
                @csrf
                {{ $method ?? '' }}

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-medium text-dark">Name</label>
                    <input type="text" name="name" id="name" value="{{ $name ?? old('name') }}"
                           class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label fw-medium text-dark">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror">{{ $description ?? old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ $submitButtonText ?? __('Create Category') }}
                    </button>
                    <a href="{{ route('admin.menu_categories.index') }}" class="btn btn-secondary">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@if($includeValidation ?? false)
    @push('scripts')
        <script>
            if (typeof jQuery === 'undefined') {
                console.error('jQuery is not loaded. Please ensure jQuery is included before jQuery Validate.');
            } else if (!$.fn.validate) {
                console.error('jQuery Validate is not loaded. Please check the CDN or inclusion in app.blade.php.');
            } else {
                console.log('jQuery and jQuery Validate are loaded successfully.');
            }

            $(document).ready(function() {
                console.log('Document ready, initializing form validation...');
                $("#{{ $formId ?? 'createMenuCategoryForm' }}").validate({
                    rules: {
                        name: {
                            required: true,
                            minlength: 3,
                            maxlength: 255
                        },
                        description: {
                            maxlength: 1000
                        }
                    },
                    messages: {
                        name: {
                            required: "Please enter a category name",
                            minlength: "Category name must be at least 3 characters long",
                            maxlength: "Category name cannot exceed 255 characters"
                        },
                        description: {
                            maxlength: "Description cannot exceed 1000 characters"
                        }
                    },
                    errorElement: "div",
                    errorClass: "invalid-feedback",
                    validClass: "is-valid",
                    highlight: function(element) {
                        $(element).addClass("is-invalid").removeClass("is-valid");
                    },
                    unhighlight: function(element) {
                        $(element).removeClass("is-invalid").addClass("is-valid");
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element);
                    },
                    submitHandler: function(form) {
                        console.log('Form is valid, submitting...');
                        form.submit();
                    },
                    invalidHandler: function(event, validator) {
                        console.log('Form validation failed:', validator.errorList);
                    }
                });
            });
        </script>
    @endpush
@endif