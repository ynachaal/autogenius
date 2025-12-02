<div>
    <h2 class="h5 font-weight-bold text-dark mb-3">
        {{ __('Update Password') }}
    </h2>
    <p class="text-muted mb-4 small">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </p>
    <form method="POST" action="{{ route('password.update') }}" class="mb-3">
        @csrf
        @method('PUT')

        <!-- Current Password -->
        <div class="input-group mb-3">
            <span class="input-group-text" id="current-password-addon"><i class="bi bi-lock"></i></span>
            <input type="password"
                   name="current_password"
                   id="update_password_current_password"
                   class="form-control @error('current_password') is-invalid @enderror"
                   placeholder="{{ __('Current Password') }}"
                   aria-label="Current Password"
                   aria-describedby="current-password-addon"
                   autocomplete="current-password"
                   required>
            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="input-group mb-3">
            <span class="input-group-text" id="password-addon"><i class="bi bi-lock-fill"></i></span>
            <input type="password"
                   name="password"
                   id="update_password_password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="{{ __('New Password') }}"
                   aria-label="New Password"
                   aria-describedby="password-addon"
                   autocomplete="new-password"
                   required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="input-group mb-3">
            <span class="input-group-text" id="password-confirmation-addon"><i class="bi bi-lock-fill"></i></span>
            <input type="password"
                   name="password_confirmation"
                   id="update_password_password_confirmation"
                   class="form-control @error('password_confirmation') is-invalid @enderror"
                   placeholder="{{ __('Confirm Password') }}"
                   aria-label="Confirm Password"
                   aria-describedby="password-confirmation-addon"
                   autocomplete="new-password"
                   required>
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-end gap-2">
            @if (session('status') === 'password-updated')
                <div class="alert alert-success alert-dismissible fade show small" role="alert">
                    {{ __('Saved.') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <button type="submit"
                    class="btn btn-sm btn-primary"
                    data-toggle="tooltip"
                    title="Save Password">
                <i class="bi bi-save me-1"></i> {{ __('Save') }}
            </button>
        </div>
    </form>
</div>