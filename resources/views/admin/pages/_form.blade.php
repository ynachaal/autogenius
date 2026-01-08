<div class="py-4">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ $action }}" id="{{ $formId ?? 'page-form' }}" onsubmit="return syncQuillContent()">
                    @csrf
                    {{ $method ?? '' }}

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ $title ?? old('title') }}" {{ $required ?? 'required' }} autofocus>
                        @error('title')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug (Optional) -->
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug (optional - leave blank to auto-generate)</label>
                        <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                               value="{{ $slug ?? old('slug') }}">
                        @error('slug')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Content - Quill Editor -->
                    <div class="mb-3">
                        <label for="editor" class="form-label">Page Content</label>
                        <textarea id="content" name="content" style="display: none;">{{ $content ?? old('content') }}</textarea>
                        <div id="editor" style="height: 400px; border: 1px solid #ced4da; border-radius: 0.25rem; background-color: #fff;"></div>
                        @error('content')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Published Checkbox -->
                    <div class="form-check mb-4">
                        <input type="hidden" name="is_published" value="0">
                        <input class="form-check-input" type="checkbox" value="1" id="is_published" name="is_published"
                               {{ ($is_published ?? old('is_published')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">Publish Page</label>
                        @error('is_published')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">{{ $submitButtonText ?? __('Create Page') }}</button>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
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
            $("#{{ $formId ?? 'page-form' }}").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    slug: {
                        maxlength: 255,
                        regex: /^[a-z0-9-]*$/ // Allow lowercase letters, numbers, and hyphens
                    },
                    content: {
                        required: true,
                        minlength: 10
                    }
                },
                messages: {
                    title: {
                        required: "Please enter a page title",
                        minlength: "Title must be at least 3 characters long",
                        maxlength: "Title cannot exceed 255 characters"
                    },
                    slug: {
                        maxlength: "Slug cannot exceed 255 characters",
                        regex: "Slug can only contain lowercase letters, numbers, and hyphens"
                    },
                    content: {
                        required: "Please enter page content",
                        minlength: "Content must be at least 10 characters long"
                    }
                },
                errorElement: "div",
                errorClass: "text-danger small mt-1",
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

            // Custom regex method for slug
            $.validator.addMethod("regex", function(value, element, regexp) {
                if (!value) return true; // Optional field
                var re = new RegExp(regexp);
                return re.test(value);
            }, "Please enter a valid slug.");

            // Update content validation on Quill change
            quill.on('text-change', function() {
                $("#content").val(quill.root.innerHTML);
                $("#content").valid();
            });
        });
    </script>
@endpush