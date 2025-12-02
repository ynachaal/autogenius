<div class="py-4">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="fw-semibold mb-4">{{ $header ?? __('Post Details') }}</h5>

                <form action="{{ $action }}" method="POST" id="{{ $formId ?? 'blog-form' }}" onsubmit="return syncQuillContent()">
                    @csrf
                    {{ $method ?? '' }}

                    {{-- Title --}}
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" value="{{ $title ?? old('title') }}"
                               class="form-control @error('title') is-invalid @enderror" {{ $required ?? 'required' }}>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Category Dropdown --}}
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" {{ $required ?? 'required' }}>
                            <option value="" disabled {{ !old('category_id') && !isset($category_id) ? 'selected' : '' }}>Select a Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        {{ (string) $category->id === (string) ($category_id ?? old('category_id')) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Quill Editor --}}
                    <div class="mb-3">
                        <label for="editor" class="form-label">Content</label>
                        <textarea id="content" name="content" style="display: none;">{{ $content ?? old('content') }}</textarea>
                        <div id="editor" style="height: 400px; background-color: white; border: 1px solid #ced4da; border-radius: 0.375rem;"></div>
                        @error('content')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Publish Checkbox --}}
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1"
                               {{ ($is_published ?? old('is_published')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">{{ $publishLabel ?? __('Publish Immediately') }}</label>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-success">{{ $submitButtonText ?? __('Save Post') }}</button>
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Initialize Quill editor
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'image'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });

        // Sync Quill content to hidden textarea
        function syncQuillContent() {
            var content = quill.root.innerHTML;
            document.getElementById('content').value = content;
            return true;
        }

        // Debugging jQuery and jQuery Validate
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded. Please ensure jQuery is included before jQuery Validate.');
        } else if (!$.fn.validate) {
            console.error('jQuery Validate is not loaded. Please check the CDN or inclusion in app.blade.php.');
        } else {
            console.log('jQuery and jQuery Validate are loaded successfully.');
        }

        $(document).ready(function() {
            console.log('Document ready, initializing form validation...');
            $("#{{ $formId ?? 'blog-form' }}").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    category_id: {
                        required: true
                    },
                    content: {
                        required: true,
                        minlength: 10
                    }
                },
                messages: {
                    title: {
                        required: "Please enter a blog title",
                        minlength: "Title must be at least 3 characters long",
                        maxlength: "Title cannot exceed 255 characters"
                    },
                    category_id: {
                        required: "Please select a category"
                    },
                    content: {
                        required: "Please enter blog content",
                        minlength: "Content must be at least 10 characters long"
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
                    if (element.attr("name") === "content") {
                        error.insertAfter("#editor");
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    syncQuillContent();
                    console.log('Form is valid, submitting...');
                    form.submit();
                },
                invalidHandler: function(event, validator) {
                    console.log('Form validation failed:', validator.errorList);
                }
            });

            // Custom validation method for Quill content
            $.validator.addMethod("quillContent", function(value, element) {
                var content = quill.root.innerHTML;
                return content.replace(/<[^>]+>/g, '').trim().length > 0;
            }, "Please enter some content in the editor.");

            // Update content validation on Quill change
            quill.on('text-change', function() {
                $("#content").val(quill.root.innerHTML);
                $("#content").valid();
            });
        });
    </script>
@endpush