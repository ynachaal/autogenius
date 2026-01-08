<div class="py-4">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="fw-semibold mb-4">{{ $header ?? __('User Details') }}</h5>

                <form action="{{ $action }}" method="POST" id="{{ $formId ?? 'user-form' }}">
                    @csrf
                    {{ $method ?? '' }}

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" value="{{ $name ?? old('name') }}"
                               class="form-control @error('name') is-invalid @enderror" {{ $required ?? 'required' }}>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" {{ $required ?? 'required' }}>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ $passwordLabel ?? __('Password') }}</label>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" {{ $passwordRequired ?? 'required' }}>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" {{ $passwordConfirmationRequired ?? 'required' }}>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-success">{{ $submitButtonText ?? __('Save User') }}</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
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
            $("#{{ $formId ?? 'user-form' }}").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255
                    },
                    password: {
                        required: {{ $passwordRequired ? 'true' : 'function() { return $("#password").val() !== "" || $("#password_confirmation").val() !== ""; }' }},
                        minlength: 8,
                        maxlength: 255
                    },
                    password_confirmation: {
                        required: {{ $passwordRequired ? 'true' : 'function() { return $("#password").val() !== ""; }' }},
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a name",
                        minlength: "Name must be at least 2 characters long",
                        maxlength: "Name cannot exceed 255 characters"
                    },
                    email: {
                        required: "Please enter an email address",
                        email: "Please enter a valid email address",
                        maxlength: "Email cannot exceed 255 characters"
                    },
                    password: {
                        required: "Please enter a password",
                        minlength: "Password must be at least 8 characters long",
                        maxlength: "Password cannot exceed 255 characters"
                    },
                    password_confirmation: {
                        required: "Please confirm the password",
                        equalTo: "Passwords do not match"
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