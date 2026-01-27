@extends('layouts.front')

@section('title', 'Our Services')

@section('content')
<section class="services-page py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="mb-3">Our Services</h1>
            <p class="text-muted">
                Explore the services we offer to help you make confident decisions.
            </p>
        </div>

        @if($data['services']->count())
            <div class="row g-4">
                @foreach($data['services'] as $service)
                    <div class="col-md-6 col-lg-4">
                        <div class="service-card h-100 p-4 border rounded">
                            
                            @if(!empty($service->icon))
                                <div class="mb-3">
                                    <i class="{{ $service->icon }} fs-2"></i>
                                </div>
                            @endif

                            <h4 class="mb-2">{{ $service->title }}</h4>

                            <p class="text-muted mb-3">
                                {{ $service->short_description }}
                            </p>

                            <a href="{{ route('services.show', $service->slug) }}"
                               class="btn btn-outline-primary btn-sm">
                                Learn More
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-muted">
                <p>No services available at the moment.</p>
            </div>
        @endif
    </div>
</section>
@endsection
