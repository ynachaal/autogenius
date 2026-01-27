<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Slider Category: :name', ['name' => $sliderCategory->name]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Slider Category Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.slider-categories.edit', $sliderCategory) }}" 
                           class="btn btn-sm btn-primary" 
                           data-toggle="tooltip" 
                           title="Edit Category">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>

                        <form action="{{ route('admin.slider-categories.destroy', $sliderCategory) }}" 
                              method="POST" 
                              class="d-inline" 
                              id="delete-form-{{ $sliderCategory->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-sm btn-danger" 
                                    data-toggle="tooltip" 
                                    title="Delete Category"
                                      onclick="return confirm('This action cannot be undone. Delete this category?')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>

                        <a href="{{ route('admin.slider-categories.index') }}" 
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
                                <strong>Status:</strong> 
                                @if($sliderCategory->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Created At:</strong> {{ $sliderCategory->created_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-2">
                                <strong>Last Updated:</strong> {{ $sliderCategory->updated_at->format('M d, Y H:i') }}
                            </p>
                            @if($sliderCategory->deleted_at)
                                <p class="text-danger mb-2">
                                    <strong>Deleted At:</strong> {{ $sliderCategory->deleted_at->format('M d, Y H:i') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <hr class="my-3">

                    <div>
                        <strong>Description:</strong>
                        <p class="text-muted">
                            {{ $sliderCategory->description ?: 'No description provided.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>