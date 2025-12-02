<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Menu: :title', ['title' => $menu->title]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Menu Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.menus.edit', $menu) }}"
                           class="btn btn-sm btn-primary"
                           data-toggle="tooltip"
                           title="Edit Menu">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.menus.destroy', $menu) }}"
                              method="POST"
                              class="d-inline"
                              id="delete-form-{{ $menu->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    data-toggle="tooltip"
                                    title="Delete Menu"
                                    onclick="return showConfirmationModal('delete-form-{{ $menu->id }}', '{{ Str::limit($menu->title, 60) }}', 'Menu')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                        <a href="{{ route('admin.menus.index') }}"
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
                                <strong>ID:</strong> <span class="fw-semibold">{{ $menu->id }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Title:</strong> <span class="fw-semibold">{{ $menu->title }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Link:</strong>
                                <span class="fw-semibold">
                                    @if ($menu->external_link)
                                        {{ $menu->external_link }}
                                    @elseif ($menu->page_id)
                                        Page: {{ $menu->page->title }}
                                    @elseif ($menu->post_id)
                                        Post: {{ $menu->post->title }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Parent:</strong> <span class="fw-semibold">{{ $menu->parent ? $menu->parent->title : '-' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Category:</strong> <span class="fw-semibold">{{ $menu->category ? $menu->category->name : '-' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Order:</strong> <span class="fw-semibold">{{ $menu->order }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Active:</strong> <span class="fw-semibold">{{ $menu->is_active ? 'Yes' : 'No' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Created at:</strong> {{ $menu->created_at->format('M d, Y') }}
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Updated at:</strong> {{ $menu->updated_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>