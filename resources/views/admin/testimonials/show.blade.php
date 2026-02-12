<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 fw-bold text-dark mb-0">{{ __('Testimonial Details') }}</h2>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="row">
                {{-- Main Content Column --}}
                <div class="col-md-8">
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">{{ $testimonial->title }}</h3>
                            <div class="card-tools">
                                <span class="badge {{ $testimonial->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $testimonial->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5>Content:</h5>
                            <div class="testimonial-text p-3 bg-light rounded border-start border-primary border-4">
                                {!! $testimonial->description !!}
                            </div>

                            @if($testimonial->youtube_url)
                                <div class="mt-4">
                                    <h5>Video Review:</h5>
                                    <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden">
                                        @php
                                            // Simple logic to convert watch URL to embed URL
                                            $videoId = current(array_reverse(explode('v=', $testimonial->youtube_url)));
                                            if(str_contains($videoId, '&')) $videoId = explode('&', $videoId)[0];
                                            // Handle short share links (youtu.be)
                                            if(str_contains($testimonial->youtube_url, 'youtu.be/')) {
                                                $videoId = current(array_reverse(explode('/', $testimonial->youtube_url)));
                                            }
                                        @endphp
                                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar Column --}}
                <div class="col-md-4">
                    {{-- Image Card --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h3 class="card-title">Author Image</h3>
                        </div>
                        <div class="card-body text-center">
                            @if($testimonial->image)
                                <img src="{{ asset('storage/' . $testimonial->image) }}" 
                                     alt="{{ $testimonial->title }}" 
                                     class="img-fluid rounded shadow-sm border" 
                                     style="max-height: 250px; width: 100%; object-fit: cover;">
                            @else
                                <div class="bg-light py-5 border rounded">
                                    <i class="bi bi-person-bounding-box text-secondary" style="font-size: 4rem;"></i>
                                    <p class="text-muted mt-2 mb-0">No image uploaded</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Metadata Card --}}
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h3 class="card-title">Metadata</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <strong>Designation:</strong>
                                    <span class="text-muted">{{ $testimonial->designation ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <strong>Display Order:</strong>
                                    <span class="badge bg-info">{{ $testimonial->order }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0">
                                    <strong>Created:</strong>
                                    <span class="text-muted">{{ $testimonial->created_at->format('M d, Y') }}</span>
                                </li>
                                <li class="list-group-item px-0">
                                    <strong>YouTube URL:</strong><br>
                                    <small><a href="{{ $testimonial->youtube_url }}" target="_blank" class="text-break">{{ $testimonial->youtube_url ?? 'N/A' }}</a></small>
                                </li>
                            </ul>
                            <div class="mt-3 d-grid gap-2">
                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-primary">
                                    <i class="bi bi-pencil me-1"></i> Edit Testimonial
                                </a>
                                
                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="bi bi-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>