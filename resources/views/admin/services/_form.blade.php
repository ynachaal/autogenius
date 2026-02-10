<div>
    <div>
        <div class="card card-primary card-outline">

            <h5 class="fw-medium pb-3 mb-3 border-bottom p-3">
                {{ $header ?? __('Service Details') }}
            </h5>

            {{-- Tabs --}}
            <ul class="nav nav-tabs px-3" id="serviceTab" role="tablist">
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

            <form action="{{ $action }}" method="POST" id="{{ $formId ?? 'service-form' }}"
                enctype="multipart/form-data" class="p-3 pt-4">

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

                            {{-- Amount --}}
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Amount</label>
                                <input type="number" name="amount" value="{{ $amount ?? old('amount') }}"
                                    class="form-control @error('amount') is-invalid @enderror" min="0" step="1"
                                    required>
                                @error('amount')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Slug (optional)</label>
                                <input type="text" name="slug" value="{{ $slug ?? old('slug') }}"
                                    class="form-control @error('slug') is-invalid @enderror">
                                <small class="text-muted">Leave blank to auto-generate. Lowercase, numbers, and hyphens
                                    only.</small>
                                @error('slug')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>

                            {{-- Sub Heading --}}
                            <div class="col-md-6">
                                <label class="form-label fw-medium">YouTube Video URL</label>
                                <input type="url" name="youtube_url" value="{{ $youtube_url ?? old('youtube_url') }}"
                                    class="form-control @error('youtube_url') is-invalid @enderror"
                                    placeholder="https://www.youtube.com/watch?v=xxxx">
                                @error('youtube_url')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>




                            {{-- Image --}}
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Service Image</label>
                                <input type="file" name="image"
                                    class="form-control @error('image') is-invalid @enderror">
                                @if(!empty($image))
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail"
                                            style="max-width:200px">
                                        <div class="form-check mt-1">
                                            <input type="checkbox" name="remove_image" value="1" class="form-check-input"
                                                id="removeImg">
                                            <label class="form-check-label text-danger small" for="removeImg">Remove
                                                existing image</label>
                                        </div>
                                    </div>
                                @endif
                                @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label for="editor" class="form-label fw-medium">Description</label>
                                <textarea name="description" id="editor" rows="4"
                                    class="form-control tinymce-editor @error('description') is-invalid @enderror">{{ $description ?? old('description') }}</textarea>
                                @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>

                            {{-- Status & Featured --}}
                            <div class="col-12 d-flex gap-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="status" value="1"
                                        @checked($status ?? old('status', true))>
                                    <label class="form-check-label">Active</label>
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="featured" value="1"
                                        @checked($featured ?? old('featured'))>
                                    <label class="form-check-label">Featured</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ================= SEO TAB ================= --}}
                    <div class="tab-pane fade" id="seo">

                        <div class="mb-3">
                            <label class="form-label fw-medium">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ $meta_title ?? old('meta_title') }}"
                                class="form-control" maxlength="100">
                            <small class="text-muted">Recommended: 100 characters</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Meta Description</label>
                            <textarea name="meta_description" rows="3" class="form-control"
                                maxlength="500">{{ $meta_description ?? old('meta_description') }}</textarea>
                            <small class="text-muted">Recommended: 500 characters</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Meta Keywords</label>
                            <input maxlength="500" type="text" name="meta_keywords"
                                value="{{ $meta_keywords ?? old('meta_keywords') }}" class="form-control">
                            <small class="text-muted">Comma separated 500 characters</small>
                        </div>

                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2 mt-3 pt-3 border-top">
                    <button type="submit" class="btn btn-success">
                        {{ $submitButtonText ?? 'Save Service' }}
                    </button>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {

            // Custom method for file size
            $.validator.addMethod("filesize", function (value, element, param) {
                if (!element.files.length) return true;
                return element.files[0].size <= param;
            }, "File size must be less than 2MB");

            // Custom method for file type
            $.validator.addMethod("filetype", function (value, element, param) {
                if (!element.files.length) return true;
                var ext = value.split('.').pop().toLowerCase();
                return $.inArray(ext, param) !== -1;
            }, "Invalid file type.");

            // Slug Regex
            if (!$.validator.methods.regex) {
                $.validator.addMethod("regex", function (value, element, regexp) {
                    if (!value) return true;
                    var re = new RegExp(regexp);
                    return re.test(value);
                }, "Please check your input.");
            }

            // Form validation
            $("#{{ $formId ?? 'service-form' }}").validate({
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
                    sub_heading: {
                        maxlength: 255
                    },
                    description: {
                        required: true,
                        minlength: 10
                    },
                    image: {
                        filetype: ["jpeg", "jpg", "png", "gif"],
                        filesize: 2097152 // 2MB
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
                    },
                    amount: {
                        required: true,
                        digits: true,   // whole numbers only
                        min: 0
                    },
                },
                messages: {
                    slug: {
                        regex: "Slug can only contain lowercase letters, numbers, and hyphens"
                    },
                    amount: {
                        required: "Amount is required",
                        digits: "Amount must be a whole number",
                        min: "Amount cannot be negative"
                    }
                },
                errorElement: "div",
                errorClass: "text-danger small mt-1",
                highlight: function (element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function (element) {
                    $(element).removeClass("is-invalid");
                },
                errorPlacement: function (error, element) {
                    if (element.hasClass("tinymce-editor")) {
                        error.insertAfter(element.closest(".mb-3").find("label"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>
@endpush