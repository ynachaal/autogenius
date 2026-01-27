<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-medium mb-0 text-dark">
            {{ __('Blog: :title', ['title' => $blog->title]) }}
        </h2>
    </x-slot>

    <div class="content">
        <div>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Blog Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.blogs.edit', $blog) }}"
                           class="btn btn-sm btn-primary"
                           data-toggle="tooltip"
                           title="Edit Blog">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
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
                                title="Delete Blog"
                                onclick="return confirm('This action cannot be undone. Delete this blog?')">
                            <i class="fa-solid fa-trash-can me-1"></i> Delete
                        </button>

                        </form>
                        <a href="{{ route('admin.blogs.index') }}"
                           class="btn btn-sm btn-secondary"
                           data-toggle="tooltip"
                           title="Back to List">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-2">
                                <strong>Slug:</strong> <span class="fw-semibold">{{ $blog->slug ?? '-' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Author:</strong> <span class="fw-semibold">{{ $blog->author->name ?? '-' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Category:</strong> <span class="fw-semibold">{{ $blog->category->name ?? 'No Category' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Status:</strong>
                                <span class="badge {{ $blog->is_published ? 'bg-success' : 'bg-warning' }}">
                                    {{ $blog->is_published ? 'Published' : 'Unpublished' }}
                                </span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Created at:</strong> {{ $blog->created_at->format('M d, Y') }}
                            </p>
                            <p class="text-muted mb-2">
                                <strong class="d-block mb-2">Featured Image:</strong>
                                @if($blog->featured_image)
                                    <img src="{{ asset($blog->featured_image) }}" alt="Featured Image"
                                         style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                                @else
                                    <span class="fw-semibold">-</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div>
                        <strong>Content:</strong>
                        <div class="text-muted">{!! $blog->content ?? '-' !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
