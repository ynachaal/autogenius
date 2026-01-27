@extends('layouts.front')

@section('title', 'Our Services')

@section('content')
    <div class="page-header bg-section parallaxie1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque" aria-label="about us" style="perspective: 400px;">Our Services</h1>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <section class="services-page py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="mb-3">Our Services</h1>
                <p>
                    Explore the services we offer to help you make confident decisions.
                </p>
            </div>

            @if($data['services']->count())
                <div class="row g-4">
                    @foreach($data['services'] as $service)
                        <x-service-card :service="$service" :delay="$loop->iteration * 0.1" />
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $data['services']->links('vendor.pagination.bootstrap-5') }}
                </div>
            @else
                <div class="text-center text-muted">
                    <p>No services available at the moment.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
