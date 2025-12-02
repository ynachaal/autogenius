<div>
    <h2 class="h5 font-weight-bold text-dark mb-3">
        {{ __('Delete Account') }}
    </h2>
    <p class="text-muted mb-4 small">
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please download any data or information that you wish to retain.') }}
    </p>
    <button type="button"
            class="btn btn-sm btn-danger mb-3"
            data-bs-toggle="modal"
            data-bs-target="#deleteUserModal"
            data-toggle="tooltip"
            title="Delete Account">
        <i class="bi bi-trash me-1"></i> {{ __('Delete Account') }}
    </button>
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">{{ __('Confirm Account Deletion') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('profile.destroy') }}" id="delete-user-form">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p class="text-muted small">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="password-addon"><i class="bi bi-lock"></i></span>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="{{ __('Password') }}"
                                   aria-label="Password"
                                   aria-describedby="password-addon"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal"
                                data-toggle="tooltip"
                                title="Cancel">
                            <i class="bi bi-x-circle me-1"></i> {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                                class="btn btn-sm btn-danger"
                                data-toggle="tooltip"
                                title="Delete Account">
                            <i class="bi bi-trash me-1"></i> {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>