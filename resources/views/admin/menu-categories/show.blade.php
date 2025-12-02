<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Menu Category: :name', ['name' => $menuCategory->name]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Menu Category Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.menu_categories.edit', $menuCategory) }}"
                           class="btn btn-sm btn-primary"
                           data-toggle="tooltip"
                           title="Edit Menu Category">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.menu_categories.destroy', $menuCategory) }}"
                              method="POST"
                              class="d-inline"
                              id="delete-form-{{ $menuCategory->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    data-toggle="tooltip"
                                    title="Delete Menu Category"
                                    onclick="return showConfirmationModal('delete-form-{{ $menuCategory->id }}', '{{ Str::limit($menuCategory->name, 60) }}', 'Menu Category')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                        <a href="{{ route('admin.menu_categories.index') }}"
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
                                <strong>ID:</strong> <span class="fw-semibold">{{ $menuCategory->id }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Name:</strong> <span class="fw-semibold">{{ $menuCategory->name }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Slug:</strong> <span class="fw-semibold">{{ $menuCategory->slug }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Description:</strong> <span class="fw-semibold">{{ $menuCategory->description ?: '-' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Created at:</strong> {{ $menuCategory->created_at->format('M d, Y') }}
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Updated at:</strong> {{ $menuCategory->updated_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>