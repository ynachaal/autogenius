<x-app-layout>

    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Service: :title', ['title' => $service->title]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">

                {{-- Card Header --}}
                <div class="card-header ">
                    <h3 class="card-title">Service Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.services.edit', $service) }}"
                           class="btn btn-sm btn-primary"
                           title="Edit Service">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>

                        <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" id="delete-form-{{ $service->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this service?')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>

                        <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-secondary" title="Back to List">
                             <i class="bi bi-list me-1"></i> Back
                        </a>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-2"><strong>Title:</strong> <span class="fw-semibold text-dark">{{ $service->title }}</span></p>
                            
                            {{-- Slug Added --}}
                            <p class="text-muted mb-2"><strong>Slug:</strong> <code class="text-primary">{{ $service->slug ?? '-' }}</code></p>
                            
                            <p class="text-muted mb-2"><strong>Sub Heading:</strong> <span class="fw-semibold">{{ $service->sub_heading ?? 'N/A' }}</span></p>
                            
                            <p class="text-muted mb-2"><strong>Status:</strong> 
                                <span class="badge {{ $service->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $service->status ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                            
                            <p class="text-muted mb-2"><strong>Featured:</strong> {{ $service->featured ? 'Yes' : 'No' }}</p>
                            <p class="text-muted mb-2"><strong>Created at:</strong> {{ $service->created_at->format('M d, Y') }}</p>
                            <p class="text-muted mb-2"><strong>Updated at:</strong> {{ $service->updated_at->format('M d, Y') }}</p>
                        </div>

                        <div class="col-md-6">
                            @if($service->image)
                                <p class="text-muted mb-2"><strong>Image:</strong></p>
                                <img src="{{ asset('storage/' . $service->image) }}" alt="Service Image" class="img-fluid rounded mb-2 border shadow-sm" style="max-height: 250px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span class="text-muted">No Image Uploaded</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <strong class="d-block mb-2">Description:</strong>
                        <div class="p-3 border rounded bg-light">
                            {!! $service->description ?? '<span class="text-muted">No description available.</span>' !!}
                        </div>
                    </div>

                    {{-- SEO Section Added --}}
                    <div class="card bg-light border-0">
                        <div class="card-body p-3">
                            <h5 class="fw-bold mb-3">SEO Meta Information</h5>
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <strong>Meta Title:</strong>
                                    <p class="mb-1">{{ $service->meta_title ?? '-' }}</p>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <strong>Meta Description:</strong>
                                    <p class="mb-1 small">{{ $service->meta_description ?? '-' }}</p>
                                </div>
                                <div class="col-md-12">
                                    <strong>Meta Keywords:</strong>
                                    <p class="mb-0 small text-muted">{{ $service->meta_keywords ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>