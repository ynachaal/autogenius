<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-medium mb-0 text-dark">
            {{ __('Brand: :name', ['name' => $brand->name]) }}
        </h2>
    </x-slot>

    <div class="content">
        <div>
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Brand Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.brands.edit', $brand) }}"
                           class="btn btn-sm btn-primary"
                           data-toggle="tooltip"
                           title="Edit Brand">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                        </a>
                        
                        <form action="{{ route('admin.brands.destroy', $brand) }}"
                              method="POST"
                              class="d-inline"
                              id="delete-form-{{ $brand->id }}">
                            @csrf
                            @method('DELETE')
                          <button type="submit"
        class="btn btn-sm btn-danger"
        data-toggle="tooltip"
        title="Delete Brand"
        onclick="return confirm('This action cannot be undone. Delete this brand?')">
    <i class="fa-solid fa-trash-can me-1"></i> Delete
</button>

                        </form>

                        <a href="{{ route('admin.brands.index') }}"
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
                                <strong>Slug:</strong> <span class="fw-semibold">{{ $brand->slug ?? '-' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Display Order:</strong> <span class="fw-semibold">{{ $brand->order ?? '0' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Status:</strong>
                                <span class="badge {{ $brand->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($brand->status) }}
                                </span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Featured:</strong>
                                <span class="badge {{ $brand->is_featured ? 'bg-warning text-dark' : 'bg-secondary' }}">
                                    {{ $brand->is_featured ? 'Yes' : 'No' }}
                                </span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Created at:</strong> {{ $brand->created_at->format('M d, Y') }}
                            </p>
                            <p class="text-muted mb-2">
                                <strong class="d-block mb-2">Brand Logo:</strong>
                                @if($brand->image)
                                    <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}"
                                         style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                                @else
                                    <span class="fw-semibold">-</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="col-md-6 border-start">
                            <h5 class="text-dark fw-bold mb-3">SEO & Meta Details</h5>
                            <p class="text-muted mb-2">
                                <strong>Meta Title:</strong> <span class="fw-semibold">{{ $brand->meta_title ?? 'N/A' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Meta Keywords:</strong> <span class="fw-semibold">{{ $brand->meta_keywords ?? 'N/A' }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Meta Description:</strong> 
                                <span class="d-block mt-1 small">{{ $brand->meta_description ?? 'N/A' }}</span>
                            </p>
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div>
                        <strong>Description:</strong>
                        <div class="text-muted mt-2">
                            {!! $brand->description ?? '<span class="fst-italic">No description provided.</span>' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>