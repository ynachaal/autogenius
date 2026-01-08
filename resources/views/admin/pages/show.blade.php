<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Page: :title', ['title' => $page->title]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Page Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.pages.edit', $page) }}"
                           class="btn btn-sm btn-primary"
                           data-toggle="tooltip"
                           title="Edit Page">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.pages.destroy', $page) }}"
                              method="POST"
                              class="d-inline"
                              id="delete-form-{{ $page->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    data-toggle="tooltip"
                                    title="Delete Page"
                                    onclick="return showConfirmationModal('delete-form-{{ $page->id }}', '{{ Str::limit($page->title, 60) }}', 'Page')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                        <a href="{{ route('admin.pages.index') }}"
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
                                <strong>Slug:</strong> <span class="fw-semibold">{{ $page->slug ?? '-' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Published:</strong>
                                @if($page->is_published)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-warning text-dark">No</span>
                                @endif
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Created at:</strong> {{ $page->created_at->format('M d, Y') }}
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Updated at:</strong> {{ $page->updated_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div>
                        <strong>Content:</strong>
                        <div class="page-content">{!! $page->content ?? '-' !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>