<div class="py-4">
    <div class="container">
        <div class="card card-primary card-outline shadow-sm">
            {{-- Header --}}
            <h5 class="fw-medium pb-3 mb-3 border-bottom p-3">
                {{ $header ?? __('Brand Details') }}
            </h5>

            {{-- Tabs Navigation --}}
            <ul class="nav nav-tabs px-3" id="brandTab" role="tablist">
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

            {{-- Form Start --}}
            <form action="{{ $action }}" method="POST" id="{{ $formId ?? 'brand-form' }}" enctype="multipart/form-data"
                class="p-3 pt-4">
                @csrf
                {{ $method ?? '' }}

                <div class="tab-content">
                    {{-- TAB 1: General --}}
                    <div class="tab-pane fade show active" id="general">
                        <div class="row g-3">
                            {{-- Name --}}
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Brand Name</label>
                                <input type="text" name="name" value="{{ $name ?? old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>

                            {{-- Image --}}
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Brand Logo</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"  @if(!isset($brand)) required @endif>
                                @if(isset($brand) && $brand->image)
                                  <img src="{{ asset('storage/' . $brand->image) }}" class="img-thumbnail mt-2" style="max-width:100px" alt="{{ $brand->name }}">
                                @endif
                                @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="active" @selected((old('status', $status ?? 'active' ) == 'active'))>Active</option>
                                    <option value="inactive" @selected((old('status', $status ?? '' ) == 'inactive'))>Inactive</option>
                                </select>
                            </div>

                            {{-- Order --}}
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Display Order</label>
                                <input type="number" name="order" value="{{ $order ?? old('order', 0) }}" 
                                    class="form-control @error('order') is-invalid @enderror">
                            </div>

                            {{-- Featured --}}
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_featured" value="0">
                                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" 
                                        id="is_featured" @checked($is_featured ?? old('is_featured'))>
                                    <label class="form-check-label fw-medium" for="is_featured">Featured Brand</label>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label for="editor" class="form-label fw-medium">Description</label>
                                <textarea name="description" id="editor" rows="4"
                                    class="form-control tinymce-editor @error('description') is-invalid @enderror">{{ $description ?? old('description') }}</textarea>
                                @error('description')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- TAB 2: SEO --}}
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
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-success px-4">
                        {{ $submitButtonText ?? 'Save Brand' }}
                    </button>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary px-4">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        const formId = "{{ $formId ?? 'brand-form' }}";

        // File validation methods
        if (!$.validator.methods.filesize) {
            $.validator.addMethod("filesize", function (value, element, param) {
                if (!element.files.length) return true;
                return element.files[0].size <= param;
            }, "File size must be less than 2MB");
        }

        $("#" + formId).validate({
            rules: {
                name: { required: true, minlength: 2, maxlength: 255 },
                order: { number: true },
                image: {
                    required: {{ isset($brand) ? 'false' : 'true' }},
                    extension: "jpg|jpeg|png|gif|svg|webp",
                    filesize: 2097152
                }
            },
            errorElement: "div",
            errorClass: "text-danger small mt-1",
            highlight: function (element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
                
                // Auto-switch to tab containing error
                const tabPane = $(element).closest('.tab-pane');
                if (tabPane.length) {
                    const tabId = tabPane.attr('id');
                    $(`button[data-bs-target="#${tabId}"]`).tab('show');
                }
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid").addClass("is-valid");
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") === "description") {
                    error.insertAfter("#editor");
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
</script>
@endpush