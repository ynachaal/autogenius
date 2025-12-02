<div>
    <h2 class="h5 font-weight-bold text-dark mb-3">
        {{ __('Profile Information') }}
    </h2>
    <p class="text-muted mb-4 small">
        {{ __("Update your account's profile information and email address.") }}
    </p>
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <form method="POST" action="{{ route('profile.update') }}" class="mb-3">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div class="input-group mb-3">
            <span class="input-group-text" id="name-addon"><i class="bi bi-person"></i></span>
            <input type="text"
                   name="name"
                   id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name) }}"
                   placeholder="{{ __('Name') }}"
                   aria-label="Name"
                   aria-describedby="name-addon"
                   required
                   autofocus
                   autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="input-group mb-3">
            <span class="input-group-text" id="email-addon"><i class="bi bi-envelope"></i></span>
            <input type="email"
                   name="email"
                   id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $user->email) }}"
                   placeholder="{{ __('Email') }}"
                   aria-label="Email"
                   aria-describedby="email-addon"
                   required
                   autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Verification -->
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mb-3">
                <p class="text-muted small">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification"
                            class="btn btn-link btn-sm text-primary p-0"
                            data-toggle="tooltip"
                            title="Resend Verification Email">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>
                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success alert-dismissible fade show small" role="alert">
                        {{ __('A new verification link has been sent to your email address.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        @endif

        <!-- Actions -->
        <div class="d-flex justify-content-end gap-2">
            @if (session('status') === 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show small" role="alert">
                    {{ __('Saved.') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <button type="submit"
                    class="btn btn-sm btn-primary"
                    data-toggle="tooltip"
                    title="Save Profile">
                <i class="bi bi-save me-1"></i> {{ __('Save') }}
            </button>
        </div>
    </form>
</div>