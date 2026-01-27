@extends('layouts.front')

@section('title', $data['service']->title)

@section('content')
<section class="service-detail py-5">
    <div class="container">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('services.index') }}">Services</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $data['service']->title }}
                </li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <h1 class="mb-3">{{ $data['service']->title }}</h1>

                @if(!empty($data['service']->image))
                    <img
                        src="{{ asset('storage/' . $data['service']->image) }}"
                        alt="{{ $data['service']->title }}"
                        class="img-fluid rounded mb-4"
                    >
                @endif

                <div class="service-content">
                    {!! $data['service']->description !!}
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <div class="p-4 border rounded">
                        <h5 class="mb-3">Need Help?</h5>
                        <p class="text-muted">
                            Have questions about this service? Get in touch with our team.
                        </p>

                        <a href="{{ route('frontend.contact.create') }}"
                           class="btn btn-primary w-100">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
