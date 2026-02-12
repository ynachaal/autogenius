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
                            <div class="testimonial-text p-3 bg-light rounded">
                                {!! $testimonial->description !!}
                            </div>

                            @if($testimonial->youtube_url)
                                <div class="mt-4">
                                    <h5>Video Review:</h5>
                                    <div class="ratio ratio-16x9">
                                        @php
                                            // Simple logic to convert watch URL to embed URL
                                            $videoId = current(array_reverse(explode('v=', $testimonial->youtube_url)));
                                            if(str_contains($videoId, '&')) $videoId = explode('&', $videoId)[0];
                                        @endphp
                                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h3 class="card-title">Metadata</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Display Order:</strong>
                                    <span>{{ $testimonial->order }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Created:</strong>
                                    <span>{{ $testimonial->created_at->format('M d, Y') }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>YouTube URL:</strong><br>
                                    <small><a href="{{ $testimonial->youtube_url }}" target="_blank" class="text-break">{{ $testimonial->youtube_url ?? 'N/A' }}</a></small>
                                </li>
                            </ul>
                            <div class="mt-3 d-grid gap-2">
                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-primary">
                                    <i class="bi bi-pencil"></i> Edit Testimonial
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>