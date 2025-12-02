<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Blog Post: :title', ['title' => $blog->title]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Blog Post Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.blogs.edit', $blog) }}"
                           class="btn btn-sm btn-primary"
                           data-toggle="tooltip"
                           title="Edit Post">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.blogs.destroy', $blog) }}"
                              method="POST"
                              class="d-inline"
                              id="delete-form-{{ $blog->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    data-toggle="tooltip"
                                    title="Delete Post"
                                    onclick="return showConfirmationModal('delete-form-{{ $blog->id }}', '{{ Str::limit($blog->title, 60) }}', 'Blog Post')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                        <a href="{{ route('admin.blogs.index') }}"
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
                                <strong>Author:</strong> <span class="fw-semibold">{{ $blog->author->name ?? 'Unknown Author' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Category:</strong> <span class="fw-semibold">{{ $blog->category->name ?? '-' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Published:</strong>
                                @if($blog->is_published)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-warning text-dark">No</span>
                                @endif
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Created at:</strong> {{ $blog->created_at->format('M d, Y') }}
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Updated at:</strong> {{ $blog->updated_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div>
                        <strong>Content:</strong>
                        <div class="blog-content">{!! $blog->content ?? '-' !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>