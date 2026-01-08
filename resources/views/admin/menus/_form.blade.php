<div class="py-4">
    <div class="container">
        <div class="card shadow-sm rounded-lg p-4">
            <form action="{{ $action }}" method="POST" id="{{ $formId ?? 'createMenuForm' }}">
                @csrf
                {{ $method ?? '' }}

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-medium text-dark">Title</label>
                    <input type="text" name="title" id="title" value="{{ $title ?? old('title') }}"
                           class="form-control @error('title') is-invalid @enderror" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- External Link -->
                <div class="mb-3">
                    <label for="external_link" class="form-label fw-medium text-dark">External Link</label>
                    <input type="url" name="external_link" id="external_link" value="{{ $external_link ?? old('external_link') }}"
                           class="form-control @error('external_link') is-invalid @enderror">
                    @error('external_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Page -->
                <div class="mb-3">
                    <label for="page_id" class="form-label fw-medium text-dark">Page</label>
                    <select name="page_id" id="page_id" class="form-control @error('page_id') is-invalid @enderror">
                        <option value="">None</option>
                        @foreach ($pages as $page)
                            <option value="{{ $page->id }}" {{ ($page_id ?? old('page_id')) == $page->id ? 'selected' : '' }}>{{ $page->title }}</option>
                        @endforeach
                    </select>
                    @error('page_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Post -->
                <div class="mb-3">
                    <label for="post_id" class="form-label fw-medium text-dark">Post</label>
                    <select name="post_id" id="post_id" class="form-control @error('post_id') is-invalid @enderror">
                        <option value="">None</option>
                        @foreach ($posts as $post)
                            <option value="{{ $post->id }}" {{ ($post_id ?? old('post_id')) == $post->id ? 'selected' : '' }}>{{ $post->title }}</option>
                        @endforeach
                    </select>
                    @error('post_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Parent Menu -->
                <div class="mb-3">
                    <label for="parent_id" class="form-label fw-medium text-dark">Parent Menu</label>
                    <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                        <option value="">None</option>
                        @foreach ($menus as $menu)
                            <option value="{{ $menu->id }}" {{ ($parent_id ?? old('parent_id')) == $menu->id ? 'selected' : '' }}>{{ $menu->title }}</option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label for="category_id" class="form-label fw-medium text-dark">Category</label>
                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                        <option value="">None</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ ($category_id ?? old('category_id')) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Order -->
                <div class="mb-3">
                    <label for="order" class="form-label fw-medium text-dark">Order</label>
                    <input type="number" name="order" id="order" value="{{ $order ?? old('order', 0) }}"
                           class="form-control @error('order') is-invalid @enderror" min="0">
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Active -->
                <div class="mb-3">
                    <label for="is_active" class="form-label fw-medium text-dark">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ isset($is_active) ? ($is_active ? 'checked' : '') : (old('is_active') ? 'checked' : '') }}>
                        Active
                    </label>
                    @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ $submitButtonText ?? __('Create Menu') }}
                    </button>
                    <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">
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
                $("#{{ $formId ?? 'createMenuForm' }}").validate({
                    rules: {
                        title: {
                            required: true,
                            minlength: 3,
                            maxlength: 255
                        },
                        external_link: {
                            url: true,
                            maxlength: 255
                        },
                        page_id: {
                            required: function(element) {
                                return !$('input[name="external_link"]').val() && !$('select[name="post_id"]').val();
                            }
                        },
                        post_id: {
                            required: function(element) {
                                return !$('input[name="external_link"]').val() && !$('select[name="page_id"]').val();
                            }
                        },
                        category_id: {
                            required: false
                        },
                        order: {
                            number: true,
                            min: 0
                        }
                    },
                    messages: {
                        title: {
                            required: "Please enter a menu title",
                            minlength: "Menu title must be at least 3 characters long",
                            maxlength: "Menu title cannot exceed 255 characters"
                        },
                        external_link: {
                            url: "Please enter a valid URL",
                            maxlength: "External link cannot exceed 255 characters"
                        },
                        page_id: {
                            required: "Please select a page, post, or provide an external link"
                        },
                        post_id: {
                            required: "Please select a page, post, or provide an external link"
                        },
                        order: {
                            number: "Order must be a valid number",
                            min: "Order cannot be negative"
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