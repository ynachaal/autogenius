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