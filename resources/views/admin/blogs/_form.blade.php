<div>
    <div>
        <div class="card card-primary card-outline">

            <h5 class="fw-medium pb-3 mb-3 border-bottom p-3">
                {{ $header ?? __('Post Details') }}
            </h5>

            {{-- Tabs --}}
            <ul class="nav nav-tabs px-3" id="blogTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general" type="button">
                        General
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#seo" type="button">
                        SEO
                    </button>
                </li>
            </ul>

            <form action="{{ $action }}" method="POST" id="{{ $formId ?? 'blog-form' }}" enctype="multipart/form-data"
                class="p-3 pt-4">

                @csrf
                {{ $method ?? '' }}

                <div class="tab-content">

                    <div class="tab-pane fade show active" id="general">
                        <div class="row g-3">
                            {{-- Title --}}
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Title</label>
                                <input type="text" name="title" value="{{ $title ?? old('title') }}"
                                    class="form-control @error('title') is-invalid @enderror" required>
                                @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Slug (optional)</label>
                                <input type="text" name="slug" value="{{ $slug ?? old('slug') }}"
                                    class="form-control @error('slug') is-invalid @enderror">
                                @error('slug')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>

                            {{-- Author --}}
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Author</label>
                                <select name="author_id" class="form-select @error('author_id') is-invalid @enderror"
                                    required>
                                    <option value="">Select Author</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @selected(($author_id ?? old('author_id')) == $user->id)>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('author_id')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>

                            {{-- Category --}}
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Category</label>
                                <select name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(($category_id ?? old('category_id')) == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>

                            {{-- Featured Image --}}
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Featured Image</label>
                                <input type="file" name="featured_image" class="form-control">
                                @if(isset($blog) && $blog->featured_image)
                                    <img src="{{ asset($blog->featured_image) }}" class="img-thumbnail mt-2"
                                        style="max-width:200px">
                                @endif
                            </div>

                            {{-- Publish --}}
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check mt-2">
                                    <input type="checkbox" class="form-check-input" name="is_published" value="1"
                                        @checked($is_published ?? old('is_published'))>
                                    <label class="form-check-label">Publish</label>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="col-12">
                                <label for="editor" class="form-label">Page Content</label>
                                <textarea name="content" id="editor" rows="4"
                                    class="form-control tinymce-editor @error('content') is-invalid @enderror">{{ $content ?? old('content') }}</textarea>
                                @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- ================= SEO TAB ================= --}}
                    <div class="tab-pane fade" id="seo">

                        <div class="mb-3">
                            <label class="form-label fw-medium">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ $meta_title ?? old('meta_title') }}"
                                class="form-control" maxlength="60">
                            <small class="text-muted">Recommended: 50–60 characters</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Meta Description</label>
                            <textarea name="meta_description" rows="3" class="form-control"
                                maxlength="160">{{ $meta_description ?? old('meta_description') }}</textarea>
                            <small class="text-muted">Recommended: 150–160 characters</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Meta Keywords</label>
                            <input type="text" name="meta_keywords" value="{{ $meta_keywords ?? old('meta_keywords') }}"
                                class="form-control">
                            <small class="text-muted">Comma separated</small>
                        </div>

                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-success">
                        {{ $submitButtonText ?? 'Save Post' }}
                    </button>
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>

        $(document).ready(function () {

            // Custom method for file size (bytes)
            $.validator.addMethod("filesize", function (value, element, param) {
                if (!element.files.length) return true; // Optional field
                return element.files[0].size <= param;
            }, "File size must be less than {0} bytes");

            // Custom method for file type validation
            $.validator.addMethod("filetype", function (value, element, param) {
                if (!element.files.length) return true; // Optional
                var ext = value.split('.').pop().toLowerCase();
                return $.inArray(ext, param) !== -1;
            }, "Invalid file type.");

            // Optional regex method for slug
            if (!$.validator.methods.regex) {
                $.validator.addMethod("regex", function (value, element, regexp) {
                    if (!value) return true;
                    var re = new RegExp(regexp);
                    return re.test(value);
                }, "Please check your input.");
            }
            // Form validation
            $("#{{ $formId ?? 'blog-form' }}").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    slug: { // **ADDED CLIENT-SIDE SLUG VALIDATION**
                        maxlength: 255,
                        regex: /^[a-z0-9-]*$/ // Assuming a custom regex method exists for slug format
                    },
                    author_id: {
                        required: true
                    },
                    category_id: {
                        required: true
                    },
                    content: {
                        required: true,
                        minlength: 10
                    },
                    featured_image: {
                        filetype: ["jpeg", "jpg", "png", "gif"],
                        maxsize: 2097152 // 2MB in bytes
                    }
                },
                messages: {
                    title: {
                        required: "Please enter a blog title",
                        minlength: "Title must be at least 3 characters long",
                        maxlength: "Title cannot exceed 255 characters"
                    },
                    slug: {
                        maxlength: "Slug cannot exceed 255 characters",
                        regex: "Slug can only contain lowercase letters, numbers, and hyphens"
                    },
                    author_id: {
                        required: "Please select an author"
                    },
                    category_id: {
                        required: "Please select a category"
                    },
                    content: {
                        required: "Please enter blog content",
                        minlength: "Content must be at least 10 characters long"
                    },
                    featured_image: {
                        accept: "Please upload a valid image file (jpeg, png, jpg, gif)",
                        maxsize: "Image size cannot exceed 2MB"
                    }
                },
                errorElement: "div",
                errorClass: "text-danger small mt-1",
                validClass: "is-valid",
                highlight: function (element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element) {
                    $(element).removeClass("is-invalid").addClass("is-valid");
                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") === "content") {
                        error.insertAfter("#editor");
                    } else if (element.attr("type") === "checkbox") {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    console.log('Form is valid, submitting:', $(form).serialize());
                    form.submit();
                },
                invalidHandler: function (event, validator) {
                    console.log('Form validation failed:', validator.errorList);
                }
            });

            // Re-adding the necessary custom regex validation method, assuming it was available globally
            if (!$.validator.methods.regex) {
                $.validator.addMethod("regex", function (value, element, regexp) {
                    if (!value) return true; // Optional field check
                    var re = new RegExp(regexp);
                    return re.test(value);
                }, "Please check your input.");
            }
        });
    </script>
@endpush