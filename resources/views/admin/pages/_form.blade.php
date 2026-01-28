<div>

    <div>

        <div class="card card-primary card-outline">

            <div class="card-body">

                {{-- FORM START --}}
                <form method="POST" action="{{ $action }}" id="{{ $formId ?? 'page-form' }}"
                    onsubmit="return syncQuillContent()">

                    @csrf

                    {{ $method ?? '' }}

                    {{-- === TABS NAVIGATION === --}}
                    <ul class="nav nav-tabs" id="pageTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab"
                                data-bs-target="#general" type="button" role="tab" aria-controls="general"
                                aria-selected="true">
                                <i class="fas fa-file-alt me-1"></i> General Content
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo"
                                type="button" role="tab" aria-controls="seo" aria-selected="false">
                                <i class="fas fa-search me-1"></i> SEO Metadata
                            </button>
                        </li>
                    </ul>
                    {{-- === END TABS NAVIGATION === --}}


                    {{-- === TABS CONTENT === --}}
                    <div class="tab-content pt-3" id="pageTabContent">

                        <div class="tab-pane fade show active" id="general" role="tabpanel"
                            aria-labelledby="general-tab">
                            <div class="row g-3">

                                {{-- Title --}}
                                <div class="col-md-6">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" id="title" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ $title ?? old('title') }}" {{ $required ?? 'required' }} autofocus {{ isset($title) ? 'readonly' : '' }}>
                                    @error('title')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                {{-- Slug --}}
                                <div class="col-md-6">
                                    <label for="slug" class="form-label">Slug (optional)</label>
                                    <input type="text" id="slug" name="slug"
                                        class="form-control @error('slug') is-invalid @enderror"
                                        value="{{ $slug ?? old('slug') }}" {{ isset($slug) ? 'readonly' : '' }}>
                                    @error('slug')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                {{-- Content --}}
                                <div class="col-12">
                                    <label for="editor" class="form-label">Page Content</label>
                                    <textarea name="content" id="editor" rows="4"
                                        class="form-control tinymce-editor">{{ $content ?? old('content') }}</textarea>
                                    @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                {{-- Publish --}}
                                <div class="col-md-6 d-flex align-items-center">
                                    <div class="form-check mt-2">
                                        <input type="hidden" name="is_published"
                                            value="{{ $is_published ?? old('is_published', false) ? '1' : '0' }}">
                                        <input class="form-check-input" type="checkbox" name="is_published" value="1"
                                            id="is_published" {{ ($is_published ?? old('is_published', false)) ? 'checked' : '' }} {{ isset($page) ? 'disabled' : '' }}>
                                        <label class="form-check-label" for="is_published">Publish Page</label>
                                    </div>
                                    @error('is_published')<div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>


                        {{-- TAB 2: SEO Metadata --}}
                        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">

                            {{-- Removed the extra card wrapper inside the tab for simpler styling --}}
                            <h4 class="mb-4">SEO Tags</h4>

                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title (SEO)</label>
                                <input  maxlength="100" type="text" id="meta_title" name="meta_title"
                                    class="form-control @error('meta_title') is-invalid @enderror"
                                    value="{{ $meta_title ?? old('meta_title') }}">
                                <small class="form-text text-muted">A compelling title for search engine results. Max
                                    100 characters.</small>
                                @error('meta_title')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description (SEO)</label>
                                <textarea  maxlength="500" id="meta_description" name="meta_description" rows="3"
                                    class="form-control @error('meta_description') is-invalid @enderror">{{ $meta_description ?? old('meta_description') }}</textarea>
                                <small class="form-text text-muted">A brief summary of the page content. Max 500
                                    characters (approx).</small>
                                @error('meta_description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords (Optional)</label>
                                <input type="text"  maxlength="500" id="meta_keywords" name="meta_keywords"
                                    class="form-control @error('meta_keywords') is-invalid @enderror"
                                    value="{{ $meta_keywords ?? old('meta_keywords') }}">
                                <small class="form-text text-muted">Comma-separated keywords (less critical for modern
                                    SEO). Max 500 characters.</small>
                                @error('meta_keywords')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    {{-- === END TABS CONTENT === --}}


                    <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-4">
                        <button type="submit"
                            class="btn btn-primary">{{ $submitButtonText ?? __('Create Page') }}</button>
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>

                </form>
                {{-- FORM END --}}

            </div>
        </div>

    </div>

</div>


@push('scripts')
    <script>
        // Define custom methods BEFORE the document ready, so they are available immediately.

        // Custom regex method for slug
        $.validator.addMethod("regex", function (value, element, regexp) {
            if (!value) return true; // Treat as optional if empty
            var re = new RegExp(regexp);
            return re.test(value);
        }, "Slug can only contain lowercase letters, numbers, and hyphens.");

        $(document).ready(function () {
            console.log('Document ready, initializing form validation...');

            // Define form ID dynamically, falling back to 'page-form'
            const formId = "{{ $formId ?? 'page-form' }}";

            $("#" + formId).validate({
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
                        quillContent: true, // Use custom method for empty check
                        minlength: 10
                    },

                    // === NEW SEO FIELD RULES ===
                    meta_title: {
                        maxlength: 100
                    },
                    meta_description: {
                        maxlength: 500
                    },
                    meta_keywords: {
                        maxlength: 500
                    }
                    // ===========================
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
                        quillContent: "Page content cannot be empty.",
                        minlength: "Content should be meaningful (at least 10 characters)."
                    },

                    // === NEW SEO FIELD MESSAGES ===
                    meta_title: {
                        maxlength: "Meta Title cannot exceed 255 characters."
                    },
                    meta_description: {
                        maxlength: "Meta Description should be less than 500 characters."
                    },
                    meta_keywords: {
                        maxlength: "Meta Keywords should be less than 500 characters."
                    }
                    // ==============================
                },
                errorElement: "div",
                errorClass: "text-danger small mt-1",
                validClass: "is-valid",
                highlight: function (element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                    // Tab switching logic for invalid fields
                    if (element.name === 'meta_title' || element.name === 'meta_description' || element.name === 'meta_keywords') {
                        $('#seo-tab').tab('show');
                    } else if (element.name === 'title' || element.name === 'slug' || element.name === 'content') {
                        $('#general-tab').tab('show');
                    }
                },
                unhighlight: function (element) {
                    // Ignore the content textarea because highlighting/unhighlighting Quill's container is handled separately.
                    if (element.name !== 'content') {
                        $(element).removeClass("is-invalid").addClass("is-valid");
                    }
                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") === "content") {
                        // Place error message for content after the Quill editor div
                        error.insertAfter("#editor");
                    } else {
                        // Default placement for all other fields
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    // Ensure Quill content is synced before final submission

                    form.submit();
                },
                invalidHandler: function (event, validator) {
                    console.log('Form validation failed:', validator.errorList);
                    // Find the first invalid element and switch to its tab
                    if (validator.errorList.length > 0) {
                        const firstInvalid = validator.errorList[0].element.name;
                        if (firstInvalid === 'meta_title' || firstInvalid === 'meta_description' || firstInvalid === 'meta_keywords') {
                            $('#seo-tab').tab('show');
                        } else {
                            // Default to General Tab for Title, Slug, Content, etc.
                            $('#general-tab').tab('show');
                        }
                    }
                }
            });

        });
    </script>
@endpush