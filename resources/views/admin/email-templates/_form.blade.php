<div>
    <div>
        <div class="card card-primary card-outline">
            <h5 class="fw-medium pb-3 mb-3 border-bottom p-3">{{ $header ?? __('Email Template Details') }}</h5>
            <form action="{{ $action }}" method="POST" id="{{ $formId ?? 'email-template-form' }}" class="p-3 pt-0"
                enctype="multipart/form-data" onsubmit="return syncQuillContent()">
                @csrf
                {{ $method ?? '' }}

                <div class="d-flex justify-content-between">

                    {{-- Title --}}
                    <div class="col-5 mb-3">
                        <label for="title" class="form-label fw-medium text-dark">Title</label>
                        <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Once saved, cannot be changed">
                        </i>
                        <input type="text" id="title" name="title" value="{{ $title ?? old('title') }}"
                            class="form-control @error('title') is-invalid @enderror" minlength="5" maxlength="50" required autofocus
                            {{ isset($title) && !empty($title) ? 'readonly' : '' }}>
                        @error('title')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Subject --}}
                    <div class="col-5 mb-3">
                        <label for="subject" class="form-label fw-medium text-dark">Subject</label>
                        <input type="text" id="subject" name="subject" value="{{ $subject ?? old('subject') }}"
                            class="form-control @error('subject') is-invalid @enderror" minlength="5" maxlength="50"
                            required autofocus>
                        @error('subject')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Quill Editor --}}
                <div class="mb-3">
                    <label for="content" class="form-label fw-medium text-dark">Content</label>
                    <textarea name="content" id="editor" rows="2" class="form-control tinymce-editor">{{ $content ?? old('content') }}</textarea>
                    @error('content')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Publish Checkbox --}}
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1"
                        {{ $is_published ?? old('is_published') ? 'checked' : '' }}>
                    <label class="form-check-label fw-medium text-dark"
                        for="is_published">{{ $publishLabel ?? __('Publish Immediately') }}</label>
                    @error('is_published')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex gap-2 mt-3">
                    <button type="submit"
                        class="btn btn-success">{{ $submitButtonText ?? __('Save Template') }}</button>
                    <a href="{{ route('admin.email-templates.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Quill with content
            if (typeof quill !== 'undefined') {
                let initialContent = $('#content').val();
                if (initialContent) quill.root.innerHTML = initialContent;
                quill.on('text-change', function() {
                    syncQuillContent();
                    $("#content").valid();
                });
            }

            // Form validation
            $("#{{ $formId ?? 'email-template-form' }}").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    slug: {
                        maxlength: 255,
                        regex: /^[a-z0-9-]*$/
                    },
                    author_id: {
                        required: true
                    },
                    content: {
                        required: true,
                        minlength: 10
                    }
                },
                messages: {
                    title: {
                        required: "Please enter a title",
                        minlength: "Title too short",
                        maxlength: "Title too long"
                    },
                    slug: {
                        maxlength: "Slug too long",
                        regex: "Slug can only contain lowercase letters, numbers, and hyphens"
                    },
                    author_id: {
                        required: "Please select an author"
                    },
                    content: {
                        required: "Please enter content",
                        minlength: "Content too short"
                    }
                },
                errorElement: "div",
                errorClass: "text-danger small mt-1",
                highlight: function(el) {
                    $(el).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(el) {
                    $(el).removeClass("is-invalid").addClass("is-valid");
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") === "content") error.insertAfter("#editor");
                    else if (element.attr("type") === "checkbox") error.insertAfter(element.parent());
                    else error.insertAfter(element);
                }
            });

            // Add regex method if missing
            if (!$.validator.methods.regex) {
                $.validator.addMethod("regex", function(value, element, regexp) {
                    if (!value) return true;
                    return new RegExp(regexp).test(value);
                }, "Invalid format.");
            }
        });
    </script>
@endpush
