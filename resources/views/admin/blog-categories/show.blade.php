<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Blog Category: :name', ['name' => $blogCategory->name]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Category Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.blog-categories.edit', $blogCategory) }}"
                           class="btn btn-sm btn-primary"
                           data-toggle="tooltip"
                           title="Edit Category">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.blog-categories.destroy', $blogCategory) }}"
                              method="POST"
                              class="d-inline"
                              id="delete-form-{{ $blogCategory->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    data-toggle="tooltip"
                                    title="Delete Category"
                                    onclick="return showConfirmationModal('delete-form-{{ $blogCategory->id }}', '{{ Str::limit($blogCategory->name, 60) }}', 'Blog Category')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                        <a href="{{ route('admin.blog-categories.index') }}"
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
                                <strong>Slug:</strong> <span class="fw-semibold">{{ $blogCategory->slug ?? '-' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Created at:</strong> {{ $blogCategory->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div>
                        <strong>Description:</strong>
                        <p class="text-muted">{{ $blogCategory->description ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>