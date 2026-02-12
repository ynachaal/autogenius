<div class="py-4">
    <div class="container">
        <div class="card shadow-sm rounded-lg p-4">
            <form action="{{ $action }}" method="POST" id="{{ $formId ?? 'testimonialForm' }}" enctype="multipart/form-data">
                @csrf
                {{ $method ?? '' }}

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="title" class="form-label fw-medium text-dark">Title/Author Name</label>
                        <input type="text" name="title" id="title" value="{{ $title ?? old('title') }}"
                               class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3"> 
                        <label for="designation" class="form-label fw-medium text-dark">Designation (e.g. CEO, Client)</label>
                        <input type="text" name="designation" id="designation" value="{{ $designation ?? old('designation') }}"
                               class="form-control @error('designation') is-invalid @enderror" placeholder="Verified Client">
                        @error('designation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="order" class="form-label fw-medium text-dark">Display Order</label>
                        <input type="number" name="order" id="order" value="{{ $order ?? old('order', 0) }}"
                               class="form-control @error('order') is-invalid @enderror">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label fw-medium text-dark">Author Image / Thumbnail</label>
                    <input type="file" name="image" id="image" 
                           class="form-control @error('image') is-invalid @enderror" 
                           accept="image/*">
                    <div class="form-text">Recommended size: 400x400px (Square). Aspect ratio 1:1.</div>
                    
                    @if(isset($testimonial) && $testimonial->image)
                        <div class="mt-2">
                            <p class="small mb-1 text-muted">Current Image:</p>
                            <img src="{{ asset('storage/' . $testimonial->image) }}" alt="Preview" class="img-thumbnail" style="height: 100px;">
                        </div>
                    @endif

                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="youtube_url" class="form-label fw-medium text-dark">YouTube Video URL (Optional)</label>
                    <input type="url" name="youtube_url" id="youtube_url" value="{{ $youtube_url ?? old('youtube_url') }}"
                           class="form-control @error('youtube_url') is-invalid @enderror" placeholder="https://youtube.com/watch?v=...">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-medium text-dark">Testimonial Content</label>
                    <textarea name="description" id="editor" rows="4"
                              class="form-control tinymce-editor">{{ $description ?? old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" 
                               {{ ($status ?? old('status', true)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active (Visible on site)</label>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ $submitButtonText ?? __('Save Testimonial') }}
                    </button>
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $("#{{ $formId ?? 'testimonialForm' }}").validate({
            rules: {
                title: { required: true, minlength: 3 },
                designation: { maxlength: 255 }, // Add validation for designation
                description: { required: true },
                youtube_url: { url: true }
            },
            errorElement: "div",
            errorClass: "invalid-feedback",
            highlight: function(element) { $(element).addClass("is-invalid"); },
            unhighlight: function(element) { $(element).removeClass("is-invalid"); }
        });
    });
</script>
@endpush