<div class="py-4">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">{{ $header ?? __('New Frequently Asked Question') }}</h5>
                <br/>
                <br/>
                <form action="{{ $action }}" method="POST" id="{{ $formId ?? 'faq-form' }}">
                    @csrf
                    {{ $method ?? '' }}

                    <!-- Question Field -->
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input type="text" id="question" name="question" value="{{ $question ?? old('question') }}"
                               class="form-control @error('question') is-invalid @enderror" {{ $required ?? 'required' }}>
                        @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Answer Field -->
                    <div class="mb-3">
                        <label for="answer" class="form-label">Answer</label>
                        <textarea id="answer" name="answer" rows="5"
                                  class="form-control @error('answer') is-invalid @enderror" {{ $required ?? 'required' }}>{{ $answer ?? old('answer') }}</textarea>
                        @error('answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Order Field -->
                    <div class="mb-3">
                        <label for="order" class="form-label">Display Order</label>
                        <input type="number" id="order" name="order" value="{{ $order ?? old('order', $nextOrder ?? 1) }}" min="1"
                               class="form-control w-25 @error('order') is-invalid @enderror" {{ $required ?? 'required' }}>
                        <div class="form-text">Lower numbers appear first.</div>
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Is Active Checkbox -->
                    <div class="form-check mb-4">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                               {{ ($is_active ?? old('is_active', 1)) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Is Active (Show on frontend)</label>
                    </div>

                    <!-- Actions -->
                    <button type="submit" class="btn btn-primary me-2">{{ $submitButtonText ?? __('Save FAQ') }}</button>
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
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
            $("#{{ $formId ?? 'faq-form' }}").validate({
                rules: {
                    question: {
                        required: true,
                        minlength: 5,
                        maxlength: 255
                    },
                    answer: {
                        required: true,
                        minlength: 10,
                        maxlength: 1000
                    },
                    order: {
                        required: true,
                        min: 1,
                        digits: true
                    }
                },
                messages: {
                    question: {
                        required: "Please enter a question",
                        minlength: "Question must be at least 5 characters long",
                        maxlength: "Question cannot exceed 255 characters"
                    },
                    answer: {
                        required: "Please enter an answer",
                        minlength: "Answer must be at least 10 characters long",
                        maxlength: "Answer cannot exceed 1000 characters"
                    },
                    order: {
                        required: "Please enter a display order",
                        min: "Display order must be at least 1",
                        digits: "Display order must be a valid number"
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