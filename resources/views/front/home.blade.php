@extends('layouts.front')

@section('title', config('settings.meta_title', ''))

@section('content')
    <div class="hero">
        <!-- Hero Box Start -->
        <div class="hero-box parallaxie">
            <video autoplay muted loop playsinline class="bg-video">
                <source src="{{ asset('video/video-bg.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="container position-relative" style="z-index: 2;">
                <div class="row">
                    <div class="col-xl-10 mx-auto">
                        <!-- Hero Content Start -->
                        <div class="hero-content text-center">
                            <!-- Section Title Start -->
                            <div class="section-title">
                                <!-- Header End -->
                                <h1 class="text-anime-style-3" data-cursor="-opaque">
                                    {{ config('settings.home_page_banner_title', '') }}
                                </h1>
                                <p class="text-center mx-auto">{{ config('settings.home_page_banner_text', '') }}</p>
                            </div>
                            <!-- Section Title End -->

                            <!-- Hero Button Start -->
                            <div class="hero-btn wow fadeInUp gap-3 d-flex flex-wrap justify-content-center"
                                data-wow-delay="0.8s">
                                <a href="{{route('front.bookConsultation')}}" class="btn-default">Book Expert
                                    Consultation</a>
                                {{-- <a
                                    href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', config('settings.phone', '')) }}"
                                    target="_blank" class="btn-primary">Call / WhatsApp</a>--}}
                            </div>
                            <!-- Hero Button End -->
                        </div>
                        <!-- Hero Content End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero Box End -->

        <div class="our-faqs bg-white bg-section mb-2r mx-0 w-100">
            <div class="container">
                <div class="faqs-content">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center text-center">
                        <h2 class="text-anime-style-3 text-black" data-cursor="-opaque">Chosen by Thousands. Recommended with Confidence</h2>
                        <p class="text-black">Real people. Real experiences. Real trust.</p>
                    </div>
{{--                    <script src="https://elfsightcdn.com/platform.js" async></script>--}}
{{--                    <div class="rts-section-gap">--}}
{{--                        <div class="elfsight-app-57b13d5b-d445-432c-827d-7d4dfb588c0d" data-elfsight-app-lazy></div>--}}
{{--                    </div>--}}

                    <script src="https://cdn.commoninja.com/sdk/latest/commonninja.js" defer></script>
                    <div class="commonninja_component pid-4ba8dad3-119f-4e7f-87eb-e05787fba9ea"></div>

                    <a href="https://www.google.com/search?sca_esv=7ad0477d9eecaf23&si=AMgyJEtREmoPL4P1I5IDCfuA8gybfVI2d5Uj7QMwYCZHKDZ-EyGd9SNS2QSzk5CPVFcTZQ-JOqMPqpDdKtn5TNrxjncLEtWzhS1ZDd0PNsKyrLe_f8tI0gcgRY9grNtJslMlyTsEkdS9--rdeee865WZriniMkgBOQ%3D%3D&q=AutoGenius+Private+Limited+Reviews&sa=X&ved=2ahUKEwiIsMKQ6_ORAxUcSGcHHZvlMBkQ0bkNegQIIRAE&biw=1680&bih=780&dpr=2"
                        target="_blank" class="btn-default w-fit mx-auto d-block">Read Our Google Reviews</a>
                </div>
            </div>
        </div>

        <!-- Our Services Section Start -->
        <div class="our-services bg-section mb-2r mx-0 w-100">
            <div class="container">
                <div class="row section-row">
                    <div class="col-lg-12">
                        <!-- Section Title Start -->
                        <div class="section-title section-title-center">
                            <h3 class="wow fadeInUp">Our services</h3>
{{--                            <h2 class="text-anime-style-3" data-cursor="-opaque">Complete car support</h2>--}}
{{--                            <p class="custom_tag mt-0">- <span>I</span><span>'m AutoGenius</span></p>--}}
                        </div>
                        <!-- Section Title End -->
                    </div>
                </div>

                <div class="row">
                    @foreach($data['services'] as $service)
                        <x-service-card :service="$service" :delay="$loop->iteration * 0.1" />
                    @endforeach
                </div>
                <a href="{{ route('services.index') }}" class="btn-default mx-auto d-block w-fit mt-3">
                    View All Services
                </a>
            </div>
        </div>
        <!-- Our Services Section End -->

        @if(isset($data['trusted_experts']))
            <div class="about-us bg-section mx-0 w-100">
                <div class="container">
                    @if(isset($data['trusted_experts']['blocks_heading']))
                        <div class="section-title section-title-center text-center mb-5">
                            <h2 class="text-anime-style-3 text-black">
                                {{ $data['trusted_experts']['blocks_heading'] }}
                            </h2>
                        </div>
                    @endif

                    <div class="hero-info-list-ultimate row row-cols-md-3 row-cols-1">
                        @for ($i = 1; $i <= 3; $i++)
                            @if(isset($data['trusted_experts']["counter{$i}_description"]))
                                <div class="hero-info-item-ultimate wow fadeInUp col" data-wow-delay="{{ $i * 0.2 }}s">
                                    <div class="icon-box">
                                        <img src="{{ isset($data['trusted_experts']["counter{$i}_image"])
                                ? asset('storage/' . $data['trusted_experts']["counter{$i}_image"])
                                : asset("images/counter-$i.svg") }}" alt="icon">
                                    </div>
                                    <div class="hero-info-item-content-ultimate">
                                        <h3>{{ $data['trusted_experts']["counter{$i}_description"] }}</h3>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        @endif

        @if(isset($data['how_it_works']))
            <div class="our-technology mx-auto w-100">
                <div class="container">
                    <div class="row section-row">
                        <div class="col-lg-12">
                            <div class="section-title section-title-center">
                                {{-- <h3 class="wow fadeInUp">AUTOGENIUS</h3>--}}
                                <h2 class="text-anime-style-3" data-cursor="-opaque">
                                    {{ $data['how_it_works']['blocks_heading'] ?? 'How AutoGenius Works' }}
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        {{-- Left Side: Steps 1 and 2 --}}
                        <div class="col-xl-3 col-md-4 order-lg-1">
                            <div class="technology-item-list-1 wow fadeInUp" data-wow-delay="0.2s">
                                @for ($i = 1; $i <= 2; $i++)
                                    @if(isset($data['how_it_works']["counter{$i}_title"]))
                                        <div class="technology-item">
                                            <h3>
                                                <i class="fa-solid fa-{{ $i }} text-primary"></i>
                                                {{ $data['how_it_works']["counter{$i}_title"] }}
                                            </h3>
                                            @if(isset($data['how_it_works']["counter{$i}_description"]))
                                                <p>{{ $data['how_it_works']["counter{$i}_description"] }}</p>
                                            @endif
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>

                        {{-- Center: Image --}}
                        <div class="col-xl-6 order-xl-2 col-md-4 order-md-2 order-2">
                            <div class="technology-image wow fadeInUp" data-wow-delay="0.4s">
                                <figure>
                                    <img src="{{ asset($data['how_it_works']['main_image'] ?? 'images/our-technology-image.png') }}"
                                        alt="Technology Image">
                                </figure>
                            </div>
                        </div>

                        {{-- Right Side: Steps 3 and 4 --}}
                        <div class="col-xl-3 col-md-4 order-xl-3 order-md-3 order-2">
                            <div class="technology-item-list-2 wow fadeInUp" data-wow-delay="0.6s">
                                @for ($i = 3; $i <= 4; $i++)
                                    @if(isset($data['how_it_works']["counter{$i}_title"]))
                                        <div class="technology-item">
                                            <h3>
                                                <i class="fa-solid fa-{{ $i }} text-primary"></i>
                                                {{ $data['how_it_works']["counter{$i}_title"] }}
                                            </h3>
                                            @if(isset($data['how_it_works']["counter{$i}_description"]))
                                                <p>{{ $data['how_it_works']["counter{$i}_description"] }}</p>
                                            @endif
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>

                    @if(isset($data['how_it_works']['cta_label']) || isset($data['how_it_works']['cta_url']))
                        <a href="{{ $data['how_it_works']['cta_url'] ?? '#' }}" class="btn-default mt-4 mx-auto d-block w-fit">
                            {{ $data['how_it_works']['cta_label'] ?? 'Start with an Expert Consultation' }}
                        </a>
                    @endif
                </div>
            </div>
        @endif
        <!-- our Technology Section End -->

        <!-- Faqs Section Start -->
        @if(isset($data['service_area']))
            <div class="our-faqs mb-2r mx-0 w-100 pt-0">
                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-6 col-12">
                            <div class="faqs-content">
                                <div class="section-title section-title-center">
                                    <h3 class="wow fadeInUp">SERVICE AREA</h3>

                                    @if(isset($data['service_area']['heading']))
                                        <h2 class="text-anime-style-3" data-cursor="-opaque">
                                            {{ $data['service_area']['heading'] }}
                                        </h2>
                                    @endif

                                    @if(isset($data['service_area']['description']))
                                        <p>{{ $data['service_area']['description'] }}</p>
                                    @endif

                                    <div class="why-choose-list-ultimate wow fadeInUp mt-2" data-wow-delay="0.4s">
                                        <ul>
                                            @php
                                                // Dynamically filter all keys that start with 'location'
                                                $locations = array_filter($data['service_area'], function ($key) {
                                                    return str_starts_with($key, 'location');
                                                }, ARRAY_FILTER_USE_KEY);
                                            @endphp

                                            @foreach($locations as $location)
                                                <li>{{ $location }}</li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    {{-- Phone number fallback or from meta --}}
                                    <a href="tel:{{ config('settings.phone', '') }}" class="btn-default mt-4">
                                        <i class="fa-solid fa-phone"></i>
                                        {{ config('settings.phone', '') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="map-wrapper mx-auto">
                                {{-- Use DB image if available, otherwise fallback to local asset --}}
                                <img src="{{ asset($data['service_area']['map_image'] ?? 'images/maharashtra-map.svg') }}"
                                    alt="Maharashtra Map" class="map-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Faqs Section End -->

        @if(isset($data['why_choose']))
            <div class="why-choose-us-ultimate bg-section mx-0 w-100">
                <div class="container-fluid">
                    <div class="row no-gutters">
                        <div class="col-xl-6">
                            <div class="why-choose-us-content-ultimate">
                                <div class="section-title">
                                    <h2 class="text-anime-style-3" data-cursor="-opaque">
                                        {{ $data['why_choose']['heading'] ?? 'Why Choose AutoGenius' }}
                                    </h2>
                                </div>
                                <div class="why-choose-body-ultimate">
                                    <table class="table table-bordered table-dark custom_table mb-5">
                                        <tbody>
                                            @for ($i = 1; $i <= 6; $i++)
                                                @if(isset($data['why_choose']["pain_point_$i"]) && isset($data['why_choose']["solution_$i"]))
                                                    <tr>
                                                        <td>
                                                            <div>
                                                                <img src="{{ asset('images/x.svg') }}" alt="x" class="img-fluid">
                                                                {{ $data['why_choose']["pain_point_$i"] }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <img src="{{ asset('images/check.svg') }}" alt="check"
                                                                    class="img-fluid">
                                                                {{ $data['why_choose']["solution_$i"] }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>

                                @if(isset($data['why_choose']['cta_text']))
                                    @php
                                        // Optional: Splitting text by period if you want them on separate lines
                                        $ctaLines = explode('. ', $data['why_choose']['cta_text']);
                                    @endphp
                                    @foreach($ctaLines as $line)
                                        <p class="{{ $loop->last ? '' : 'm-0' }}">{{ $line }}{{ $loop->last ? '' : '.' }}</p>
                                    @endforeach
                                @endif

                                <div class="d-flex flex-wrap gap-3 mt-4">
                                    <a href="https://wa.me/+91{{ str_replace(' ', '', config('settings.phone', '')) }}?text=Hi%20AutoGenius%2C%0AI%27d%20like%20expert%20guidance%20regarding%20a%20car."
                                        class="btn-primary w-fit" target="_blank">
                                        <i class="fa-brands fa-whatsapp"></i> WhatsApp AutoGenius
                                    </a>
                                    <a href="tel:{{ config('settings.phone', '') }}" class="btn-default w-fit">
                                        <i class="fa-solid fa-phone"></i> {{ config('settings.phone', '') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="why-choose-image-ultimate">
                                <figure class="image-anime">
                                    <img src="{{ isset($data['why_choose']['image'])
                ? asset('storage/' . $data['why_choose']['image'])
                : asset('images/car-test.jpg') }}" alt="Why Choose AutoGenius">
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Why Choose Us Section End -->

        <div class="why-choose-us mb- 2r mx-0 w-100">
            <div class="container">
                <div class="col-lg-12">
                    <!-- Hero Slider Start -->
                    <div class="company-logo-slider">
                        <p>Experience across the world’s leading automotive brands</p>
                        <div class="swiper">
                            <div class="swiper-wrapper"> <x-brand-swiper :brands="$data['featuredBrands']" /> </div>
                        </div>

                    </div>
                    <!-- Hero Slider End -->
                </div>
            </div>
        </div>

        <!-- About Us Section Start -->
        @if(isset($data['protecting_buyers']))
            <div class="about-us bg-section mb-2r mx-0 w-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xxl-4 col-xl-3">
                            <div class="logo mt-5 mb-3">
                                {{-- Using the "image" key from your array --}}
                                @if(isset($data['protecting_buyers']['image']))
                                    <img src="{{ asset('storage/' . $data['protecting_buyers']['image']) }}"
                                        class="img-fluid py-3 w-75 mx-auto d-block" alt="AutoGenius Logo Icon">
                                @else
                                    <img src="{{ asset('images/logo-icon.png') }}" class="img-fluid py-3 w-75 mx-auto d-block"
                                        alt="Default Icon">
                                @endif
                            </div>
                        </div>

                        <div class="col-xxl-8 col-xl-9">
                            <div class="about-us-content">
                                <div class="section-title">
                                    <h2 class="text-effect" data-cursor="-opaque">
                                        {{ $data['protecting_buyers']['heading'] ?? 'Protecting Buyers from Costly Car Mistakes' }}
                                    </h2>

                                    {{-- Handling description1 --}}
                                    @if(isset($data['protecting_buyers']['description1']))
                                        <p>{!! nl2br(e($data['protecting_buyers']['description1'])) !!}</p>
                                    @endif

                                    {{-- Handling description2 (The Quote) --}}
                                    @if(isset($data['protecting_buyers']['description2']))
                                        <p><strong>{{ $data['protecting_buyers']['description2'] }}</strong></p>
                                    @endif
                                </div>
                                <div class="about-us-body wow fadeInUp" data-wow-delay="0.2s">
                                    <div class="about-us-btn">
                                        {{-- Link to contact or lead form --}}
                                        <a href="tel:{{ config('settings.phone', '') }}" class="btn-default">
                                            Talk to an Expert Before You Decide
                                        </a>
                                    </div>

                                    {{-- Hidden contact list from original template --}}
                                    <div class="about-contact-items-list d-none">
                                        <div class="about-contact-item">
                                            <div class="icon-box">
                                                <img src="{{ asset('images/icon-phone-accent.svg') }}" alt="">
                                            </div>
                                            <div class="about-contact-item-content">
                                                <h3>Contact Info</h3>
                                                <p>{{ config('settings.phone', '') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- About Us Section End -->

        <!-- Our Approach Section Start -->

        @if(isset($data['about']))
            <div class="our-approach bg-section mx-0 w-100">
                <div class="container">
                    <div class="row align-items-center">
                        <x-slider-carousel :sliders="$sliders" carousel-id="homeSlider" />
                        <div class="col-xl-6">
                            <div class="approach-content">
                                <div class="section-title">
                                    <h3 class="wow fadeInUp">About AutoGenius</h3>
                                    <h2 class="text-anime-style-3" data-cursor="-opaque">
                                        {{ $data['about']['heading'] ?? 'AUTOGENIUS WAS FOUNDED WITH ONE SIMPLE BELIEF:' }}
                                    </h2>

                                    @if(isset($data['about']['description1']))
                                        <p class="wow fadeInUp" data-wow-delay="0.2s">
                                            {!! nl2br(e($data['about']['description1'])) !!}
                                        </p>
                                    @endif
                                </div>
                                <div class="why-choose-list-ultimate wow fadeInUp mt-2 mb-2" data-wow-delay="0.4s">
                                    <ul>
                                        @php
                                            // Pulling market_issue_1, market_issue_2, etc.
                                            $issues = array_filter($data['about'], function ($key) {
                                                return str_contains($key, 'market_issue_');
                                            }, ARRAY_FILTER_USE_KEY);
                                            ksort($issues);
                                        @endphp

                                        @foreach($issues as $issue)
                                            <li>{{ $issue }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <br>

                                {{-- Dynamic Mission Text --}}
                                @if(isset($data['about']['mission_text']))
                                    <p>{{ $data['about']['mission_text'] }}</p>
                                @endif

                                {{-- Dynamic Closing Hook --}}
                                @if(isset($data['about']['closing_hook']))
                                    @php
                                        // Splitting "We don’t sell cars. We help people buy the right one." into two lines
                                        $hooks = explode('. ', $data['about']['closing_hook']);
                                    @endphp
                                    <p>
                                        @foreach($hooks as $hook)
                                            {{ $hook }}{{ !$loop->last ? '.' : '' }} @if(!$loop->last) <br> @endif
                                        @endforeach
                                    </p>
                                @endif

                                <a href="tel:{{ config('settings.phone', '') }}" class="btn-default mt-3">
                                    Speak to an AutoGenius Expert
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif
        <!-- Our Approach Section End -->

        <!-- What We Do Section Start -->
        @if(isset($data['why_founded']))
            <div class="what-we-do-ultimate">
                <div class="container">
                    <div class="row section-row">
                        <div class="col-lg-12">
                            <div class="section-title section-title-center">
                                <h3 class="wow fadeInUp">
                                    {{ $data['why_founded']['blocks_heading'] ?? 'WHY WE FOUNDED AUTOGENIUS' }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Left Image --}}
                        <div class="col-xl-3 col-md-6">
                            <div class="what-we-image-ultimate wow fadeInUp">
                                <figure class="image-anime">
                                    <img src="{{ isset($data['why_founded']['image1'])
                ? asset('storage/' . $data['why_founded']['image1'])
                : asset('images/img-1.jpg') }}" alt="Car Inspection">
                                </figure>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6">
                            <div class="what-we-item-box-ultimate wow fadeInUp" data-wow-delay="0.2s">
                                <div class="what-we-client-box-ultimate">
                                    {{-- Main Statement --}}
                                    <div class="what-we-client-content-ultimate">
                                        <h3>{{ $data['why_founded']['main_quote'] ?? 'Most car problems don’t start on the road - they start at the time of purchase.' }}
                                        </h3>
                                    </div>

                                    <div class="why-choose-list-ultimate w-100 wow fadeInUp mt-3 mb-2" data-wow-delay="0.4s">
                                        {{-- Database Key: why-we-founded-autogenius_mission_intro --}}
                                        @if(isset($data['why_founded']['mission_intro']))
                                            <p class="mb-2">{{ $data['why_founded']['mission_intro'] }}</p>
                                        @endif

                                        <ul>
                                            @php
                                                // Filters keys like purpose_1, purpose_2, etc.
                                                $purposes = array_filter($data['why_founded'], function ($key) {
                                                    return str_contains($key, 'purpose_');
                                                }, ARRAY_FILTER_USE_KEY);

                                                ksort($purposes);
                                            @endphp

                                            @foreach($purposes as $purpose)
                                                <li>{{ $purpose }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <br />
                                    {{-- Database Key: why-we-founded-autogenius_closing_text --}}
                                    @if(isset($data['why_founded']['closing_text']))
                                        <p>{{ $data['why_founded']['closing_text'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Right Image --}}
                        <div class="col-xl-3 col-md-12">
                            <div class="what-we-image-ultimate wow fadeInUp">
                                <figure class="image-anime">
                                    <img src="{{ isset($data['why_founded']['image2'])
                ? asset('storage/' . $data['why_founded']['image2'])
                : asset('images/car-cust.jpg') }}" alt="Customer Satisfaction">
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- What We Do Section End -->
@endsection

    @push('scripts')
        <script>
            const locations = [
                { name: "", top: "59%", left: "8%" },
                { name: "", top: "25%", left: "30%" },
                { name: "", top: "45%", left: "50%" },
                { name: "", top: "33%", left: "25%" },
                { name: "", top: "51%", left: "16%" },
                { name: "", top: "42%", left: "11%" },
                { name: "", top: "85%", left: "10.5%" },
                { name: "", top: "33%", left: "4%" },
                { name: "", top: "24%", left: "12%" },
                { name: "", top: "72%", left: "17%" },
                { name: "", top: "15%", left: "34%" },
                { name: "", top: "22%", left: "44%" },
                { name: "", top: "9%", left: "72%" },
                { name: "", top: "22%", left: "67%" },
                { name: "", top: "22%", left: "44%" },
                { name: "", top: "45%", left: "30%" },
                { name: "", top: "52%", left: "38%" },
                { name: "", top: "35%", left: "42%" },
                { name: "", top: "52%", left: "38%" },
                { name: "", top: "61%", left: "25%" },
                { name: "", top: "23%", left: "57%" },
                { name: "", top: "14%", left: "57%" },
                { name: "", top: "14%", left: "85%" },
                { name: "", top: "26%", left: "81%" },
                { name: "", top: "14%", left: "17%" },
                { name: "", top: "4%", left: "17%" },
                { name: "", top: "22%", left: "22%" },
                { name: "", top: "33%", left: "15%" },
                { name: "", top: "62%", left: "16%" },
                { name: "", top: "49%", left: "5%" },
                { name: "", top: "70%", left: "8%" },
                { name: "", top: "13%", left: "49%" },
                { name: "", top: "33%", left: "64%" },
                { name: "", top: "34%", left: "33%" },
                { name: "", top: "11%", left: "27%" },
                { name: "", top: "41%", left: "21%" },
                { name: "", top: "43%", left: "38%" },
                { name: "", top: "62%", left: "33%" },
                { name: "", top: "71%", left: "28%" },
                { name: "", top: "52%", left: "26%" },
                { name: "", top: "26%", left: "37%" },
                { name: "", top: "54%", left: "46%" },
                { name: "", top: "63%", left: "41%" },
                { name: "", top: "38%", left: "56%" },
                { name: "", top: "48%", left: "58%" },
                { name: "", top: "29%", left: "50%" },
                { name: "", top: "4%", left: "54%" },
                { name: "", top: "17%", left: "77%" },
                { name: "", top: "31%", left: "73%" },
                { name: "", top: "36%", left: "88%" },
                { name: "", top: "23%", left: "90%" },
                { name: "", top: "6%", left: "89%" },
                { name: "", top: "7%", left: "80%" },
                { name: "", top: "81%", left: "19%" },
                { name: "", top: "13%", left: "64%" },
                { name: "", top: "91%", left: "17%" },
            ];
            const map = document.querySelector(".map-wrapper");
            locations.forEach(loc => {
                const pin = document.createElement("div");
                pin.className = "map-pin";
                pin.style.top = loc.top;
                pin.style.left = loc.left;
                map.appendChild(pin);
            });
        </script>
    @endpush
