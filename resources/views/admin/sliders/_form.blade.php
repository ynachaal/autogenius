<div class="py-4">
    <div class="container">
        <div class="card shadow-sm rounded-lg p-4">
            <form action="{{ $action }}" method="POST" id="{{ $formId ?? 'sliderForm' }}" enctype="multipart/form-data">
                @csrf
                {{ $method ?? '' }}

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="slider_category_id" class="form-label fw-medium text-dark">Category</label>
                        <select name="slider_category_id" id="slider_category_id" class="form-control @error('slider_category_id') is-invalid @enderror">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (isset($slider) && $slider->slider_category_id == $category->id) ? 'selected' : (old('slider_category_id') == $category->id ? 'selected' : '') }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('slider_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label fw-medium text-dark">Media Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="image" {{ (isset($slider) && $slider->type == 'image') ? 'selected' : '' }}>Image</option>
                            <!-- <option value="video" {{ (isset($slider) && $slider->type == 'video') ? 'selected' : '' }}>Video</option> -->
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="file" class="form-label fw-medium text-dark">Upload File {{ !isset($slider) ? '(Required)' : '' }}</label>
                        <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
                        @if(isset($slider))
                            <div class="mt-2">
                                <small class="text-muted">Current File: <code>{{ $slider->file }}</code></small>
                            </div>
                        @endif
                        @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="heading" class="form-label fw-medium text-dark">Heading</label>
                        <input type="text" name="heading" id="heading" value="{{ $slider->heading ?? old('heading') }}" class="form-control @error('heading') is-invalid @enderror">
                        @error('heading') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                     <div class="col-md-12 mb-3">
                        <label for="subheading" class="form-label fw-medium text-dark">Sub Heading</label>
                        <input type="text" name="subheading" id="subheading" value="{{ $slider->subheading ?? old('subheading') }}" class="form-control @error('subheading') is-invalid @enderror">
                        @error('subheading') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="button1_text" class="form-label fw-medium text-dark">Button 1 Text</label>
                        <input type="text" name="button1_text" id="button1_text" value="{{ $slider->button1_text ?? old('button1_text') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="button1_link" class="form-label fw-medium text-dark">Button 1 Link</label>
                        <input type="url" name="button1_link" id="button1_link" value="{{ $slider->button1_link ?? old('button1_link') }}" class="form-control" placeholder="https://...">
                    </div>

                     <div class="col-md-6 mb-3">
                        <label for="button2_text" class="form-label fw-medium text-dark">Button 2 Text</label>
                        <input type="text" name="button2_text" id="button2_text" value="{{ $slider->button2_text ?? old('button2_text') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="button2_link" class="form-label fw-medium text-dark">Button 2 Link</label>
                        <input type="url" name="button2_link" id="button2_link" value="{{ $slider->button2_link ?? old('button2_link') }}" class="form-control" placeholder="https://...">
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ $submitButtonText ?? __('Save Slider') }}
                    </button>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
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
            $(document).ready(function() {
                $("#{{ $formId ?? 'sliderForm' }}").validate({
                    rules: {
                        slider_category_id: {
                            required: true
                        },
                        file: {
                            required: {{ isset($slider) ? 'false' : 'true' }},
                            extension: "jpg|jpeg|png|mp4"
                        },
                        heading: {
                            maxlength: 255
                        },
                        button1_link: {
                            url: true
                        },
                         button2_link: {
                            url: true
                        }
                    },
                    messages: {
                        slider_category_id: "Please select a slider category",
                        file: {
                            required: "Please upload an image or video file",
                            extension: "Only JPG, PNG, and MP4 files are allowed"
                        },
                        button1_link: "Please enter a valid URL (starting with http:// or https://)"
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
                        form.submit();
                    }
                });
            });
        </script>
    @endpush
@endif