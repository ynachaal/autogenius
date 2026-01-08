<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('User: :name', ['name' => $user->name]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">User Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="btn btn-sm btn-primary"
                           data-toggle="tooltip"
                           title="Edit User">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}"
                              method="POST"
                              class="d-inline"
                              id="delete-form-{{ $user->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    data-toggle="tooltip"
                                    title="Delete User"
                                    onclick="return showConfirmationModal('delete-form-{{ $user->id }}', '{{ Str::limit($user->name, 60) }}', 'User')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                        <a href="{{ route('admin.users.index') }}"
                           class="btn btn-sm btn-secondary"
                           data-toggle="tooltip"
                           title="Back to List">
                            <i class="bi bi-list me-1"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-2">
                                <strong>Name:</strong> <span class="fw-semibold">{{ $user->name }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Email:</strong> <span class="fw-semibold">{{ $user->email }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Created at:</strong> {{ $user->created_at->format('M d, Y') }}
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Updated at:</strong> {{ $user->updated_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>