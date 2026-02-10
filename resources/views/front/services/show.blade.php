@extends('layouts.front')

@section('title', $data['service']->meta_title ?? '')
@section('meta_description', $data['service']->meta_description ?? '')
@section('meta_keywords', $data['service']->meta_keywords ?? '')



{{-- Breadcrumb --}}
{{--<nav aria-label="breadcrumb" class="mb-4">--}}
    {{-- <ol class="breadcrumb">--}}
        {{-- <li class="breadcrumb-item">--}}
            {{-- <a href="{{ route('home') }}">Home</a>--}}
            {{-- </li>--}}
        {{-- <li class="breadcrumb-item">--}}
            {{-- <a href="{{ route('services.index') }}">Services</a>--}}
            {{-- </li>--}}
        {{-- <li class="breadcrumb-item active" aria-current="page">--}}
            {{-- {{ $data['service']->title }}--}}
            {{-- </li>--}}
        {{-- </ol>--}}
    {{--</nav>--}}

@section('content')
    <div class="page-header bg-section parallaxie1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque" aria-label="about us"
                            style="perspective: 400px;">{{ $data['service']->title }}</h1>
                    </div>

                    <!-- Page Header Box End -->

                </div>
            </div>
        </div>
    </div>
    <section class="page-service-single py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="service-single-content">
                        <div class="service-entry">
                            <h2 class="mb-3 h5 fw-normal">{{ $data['service']->sub_heading }}</h2>
                            {!! $data['service']->description !!}
                        </div>
                        <div class="page-single-image">
                            <figure class="image-anime reveal"
                                style="opacity: 1; visibility: inherit; translate: none; rotate: none; scale: none; transform: translate(0px, 0px);">
                                @if(!empty($data['service']->image))
                                    <img src="{{ asset('storage/' . $data['service']->image) }}"
                                        alt="{{ $data['service']->title }}">
                                @endif
                            </figure>
                        </div>

                        @if(!empty($data['service']->youtube_url))
                            <div class="google-map-iframe mt-4">
                                <iframe src="{{ str_replace('watch?v=', 'embed/', $data['service']->youtube_url) }}"
                                    frameborder="0" allowfullscreen loading="lazy">
                                </iframe>
                            </div>
                        @endif

                    </div>
                    <br>
                    @php
                        $slug = $data['service']->slug;

                        // Group slugs that share the same form
                        $isLeadForm = in_array($slug, ['new-car-consultation', 'used-car-consultation-and-unlimited-inspections']);

                        $isInspectionForm = in_array($slug, [
                            'new-car-pdi',
                            'premium-luxury-car-inspection',
                            'get-your-own-car-inspected',
                            'used-car-inspection'
                        ]);
                    @endphp

                    @if($isLeadForm)
                        @include('components.forms.lead')

                    @elseif($slug === 'on-call-consultation')
                        @include('components.forms.on-call-consultation')

                    @elseif($slug === 'sell-your-car-with-autogenius')
                        @include('components.forms.sell-car')

                    @elseif($isInspectionForm)
                        @include('components.forms.car-inspection')

                    @elseif($slug === 'get-service-history-and-insurance-claim-details')
                        @include('components.forms.service-history-insurance', ['fees' => $fees])

                    @elseif($slug === 'insurance-with-autogenius')
                        <a href="tel:{{ config('settings.phone', '') }}" class="btn-default mt-3">
                            Protect Your Car with AutoGenius
                        </a>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="page-single-sidebar">
                        <div class="page-category-list wow fadeInUp p-3">
                            <h5 class="mb-3">Need Help?</h5>
                            <p>Have questions about this service? Get in touch with our team.</p>
                            <a href="{{ route('frontend.contact.create') }}" class="btn-default">
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection