@extends('layouts.front')

@section('title', 'Home Page')

@section('content')
    <div class="hero">
        <!-- Hero Box Start -->
        <div class="hero-box parallaxie">
            <video autoplay muted loop playsinline class="bg-video">
                <source src="{{ asset('video/video-bg.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <style>
                .bg-video {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    min-width: 100%;
                    min-height: 100%;
                    width: auto;
                    height: auto;
                    transform: translate(-50%, -50%);
                    object-fit: cover;
                    z-index: 1;
                }

                .hero-box::after {
                    content: "";
                    position: absolute;
                    inset: 0;
                    background: rgba(0, 0, 0, 0.4);
                    /* overlay for readability */
                    z-index: 1;
                }
            </style>
            <div class="container position-relative" style="z-index: 2;">
                <div class="row">
                    <div class="col-xl-8 mx-auto">
                        <!-- Hero Content Start -->
                        <div class="hero-content text-center">
                            <!-- Section Title Start -->
                            <div class="section-title">
                                <!-- Header End -->
                                <h1 class="text-anime-style-3" data-cursor="-opaque">India’s Most Trusted Personal Car Consultant</h1>
                                <p class="text-center mx-auto">New Cars • Pre Owned Cars • 288+ Point Inspections</p>
                            </div>
                            <!-- Section Title End -->

                            <!-- Hero Button Start -->
                            <div class="hero-btn wow fadeInUp gap-3 d-flex flex-wrap justify-content-center" data-wow-delay="0.8s">
                                <a href="javascript:void(0)" class="btn-default">Book Expert Consultation</a>
                                <a href="https://api.whatsapp.com/send?phone=918007500740" target="_blank" class="btn-primary">Call / WhatsApp</a>
                            </div>
                            <!-- Hero Button End -->
                        </div>
                        <!-- Hero Content End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero Box End -->

        <div class="our-faqs bg-white bg-section mb-2r mx-0 w-100 d-none">
            <div class="container">
                <div class="faqs-content">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center text-center">
                        <h2 class="text-anime-style-3 text-black" data-cursor="-opaque">Trusted by Car Buyers Across India</h2>
                        <p class="text-black">Real people. Real experiences. Real trust.</p>
                    </div>
                    <script src="https://elfsightcdn.com/platform.js" async></script>
                    <div class="rts-section-gap">
                        <div class="elfsight-app-57b13d5b-d445-432c-827d-7d4dfb588c0d" data-elfsight-app-lazy></div>
                    </div>
                    <a href="https://www.google.com/search?sca_esv=7ad0477d9eecaf23&si=AMgyJEtREmoPL4P1I5IDCfuA8gybfVI2d5Uj7QMwYCZHKDZ-EyGd9SNS2QSzk5CPVFcTZQ-JOqMPqpDdKtn5TNrxjncLEtWzhS1ZDd0PNsKyrLe_f8tI0gcgRY9grNtJslMlyTsEkdS9--rdeee865WZriniMkgBOQ%3D%3D&q=AutoGenius+Private+Limited+Reviews&sa=X&ved=2ahUKEwiIsMKQ6_ORAxUcSGcHHZvlMBkQ0bkNegQIIRAE&biw=1680&bih=780&dpr=2" target="_blank" class="btn-default w-fit mx-auto d-block">Read Our Google Reviews</a>
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
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Complete car support</h2>
                            <p class="custom_tag mt-0">- <span>I</span><span>'m AutoGenius</span></p>
                        </div>
                        <!-- Section Title End -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="service-item-prime wow fadeInUp">
                            <div class="service-item-image-prime">
                                <a href="javascript:void(0)">
                                    <figure>
                                        <img src="{{ asset('images/new-car-con.jpg') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="service-item-body-prime">
                                <div class="service-item-content-prime">
                                    <h3><a href="javascript:void(0)">New Car Consultation</a></h3>
                                    <p>The Smarter Way to Buy a New Car</p>
                                </div>
                                <div class="service-readmore-btn-prime">
                                    <a href="javascript:void(0)" class="readmore-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="service-item-prime wow fadeInUp">
                            <div class="service-item-image-prime">
                                <a href="javascript:void(0)">
                                    <figure>
                                        <img src="{{ asset('images/pdi.jpg') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="service-item-body-prime">
                                <div class="service-item-content-prime">
                                    <h3><a href="javascript:void(0)">New Car PDI</a></h3>
                                    <p>Expert inspection to ensure your new car is 100% defect-free before delivery.</p>
                                </div>
                                <div class="service-readmore-btn-prime">
                                    <a href="javascript:void(0)" class="readmore-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="service-item-prime wow fadeInUp">
                            <div class="service-item-image-prime">
                                <a href="javascript:void(0)">
                                    <figure>
                                        <img src="{{ asset('images/pre-own.jpg') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="service-item-body-prime">
                                <div class="service-item-content-prime">
                                    <h3><a href="javascript:void(0)">Used Car Consultation & Testing</a></h3>
                                    <p>Find the Right Car with Complete Peace of Mind</p>
                                </div>
                                <div class="service-readmore-btn-prime">
                                    <a href="javascript:void(0)" class="readmore-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="service-item-prime wow fadeInUp">
                            <div class="service-item-image-prime">
                                <a href="javascript:void(0)">
                                    <figure>
                                        <img src="{{ asset('images/sell.jpg') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="service-item-body-prime">
                                <div class="service-item-content-prime">
                                    <h3><a href="javascript:void(0)">USED CAR TESTING</a></h3>
                                    <p>Complete Health & Condition Check Before You Buy</p>
                                </div>
                                <div class="service-readmore-btn-prime">
                                    <a href="javascript:void(0)" class="readmore-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="service-item-prime wow fadeInUp">
                            <div class="service-item-image-prime">
                                <a href="javascript:void(0)">
                                    <figure>
                                        <img src="{{ asset('images/prem.jpg') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="service-item-body-prime">
                                <div class="service-item-content-prime">
                                    <h3><a href="javascript:void(0)">Premium & Luxury Car Inspection</a></h3>
                                    <p>Complete 360° health check of your car</p>
                                </div>
                                <div class="service-readmore-btn-prime">
                                    <a href="javascript:void(0)" class="readmore-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="service-item-prime wow fadeInUp">
                            <div class="service-item-image-prime">
                                <a href="javascript:void(0)">
                                    <figure>
                                        <img src="{{ asset('images/car1.jpg') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="service-item-body-prime">
                                <div class="service-item-content-prime">
                                    <h3><a href="javascript:void(0)">ON-CALL CAR CONSULTATION</a></h3>
                                    <p>Expert Car Advice — Anytime, Anywhere.</p>
                                </div>
                                <div class="service-readmore-btn-prime">
                                    <a href="javascript:void(0)" class="readmore-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="service-item-prime wow fadeInUp">
                            <div class="service-item-image-prime">
                                <a href="javascript:void(0)">
                                    <figure>
                                        <img src="{{ asset('images/call.jpg') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="service-item-body-prime">
                                <div class="service-item-content-prime">
                                    <h3><a href="javascript:void(0)">Sell Your Car with AutoGenius</a></h3>
                                    <p>The Smartest, Fastest & Most Transparent Way to Sell Your Car</p>
                                </div>
                                <div class="service-readmore-btn-prime">
                                    <a href="javascript:void(0)" class="readmore-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="service-item-prime wow fadeInUp">
                            <div class="service-item-image-prime">
                                <a href="javascript:void(0)">
                                    <figure>
                                        <img src="{{ asset('images/inc.jpg') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="service-item-body-prime">
                                <div class="service-item-content-prime">
                                    <h3><a href="javascript:void(0)">Insurance with AutoGenius</a></h3>
                                    <p>Trusted. Transparent. Hassle-Free.</p>
                                </div>
                                <div class="service-readmore-btn-prime">
                                    <a href="javascript:void(0)" class="readmore-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0)" class="btn-default mx-auto d-block w-fit mt-3">View All Services</a>
            </div>
        </div>
        <!-- Our Services Section End -->

        <div class="about-us bg-section mx-0 w-100">
            <div class="container">
                <div class="section-title section-title-center text-center mb-5">
                    <h2 class="text-anime-style-3 text-black">India’s Trusted Car Experts Since 2016</h2>
                </div>
                <div class="hero-info-list-ultimate row row-cols-md-3 row-cols-1">
                    <!-- Hero Info Item Start -->
                    <div class="hero-info-item-ultimate wow fadeInUp col">
                        <div class="icon-box">
                            <img src="{{ asset('images/car-inspected.svg') }}" alt="">
                        </div>
                        <div class="hero-info-item-content-ultimate">
                            <h3>35000+ Cars Inspected </h3>
                        </div>
                    </div>
                    <!-- Hero Info Item End -->

                    <!-- Hero Info Item Start -->
                    <div class="hero-info-item-ultimate wow fadeInUp col">
                        <div class="icon-box">
                            <img src="{{ asset('images/google-rating.svg') }}" alt="">
                        </div>
                        <div class="hero-info-item-content-ultimate">
                            <h3>5-Star Google Rating</h3>
                        </div>
                    </div>
                    <!-- Hero Info Item End -->

                    <!-- Hero Info Item Start -->
                    <div class="hero-info-item-ultimate wow fadeInUp col">
                        <div class="icon-box">
                            <img src="{{ asset('images/money.svg') }}" alt="">
                        </div>
                        <div class="hero-info-item-content-ultimate">
                            <h3>₹100+ Crores Saved for Customers</h3>
                        </div>
                    </div>
                    <!-- Hero Info Item End -->
                </div>
            </div>
        </div>

        <!-- our Technology Section Start -->
        <div class="our-technology mx-auto w-100">
            <div class="container">
                <div class="row section-row">
                    <div class="col-lg-12">
                        <!-- Section Title Start -->
                        <div class="section-title section-title-center">
                            <h3 class="wow fadeInUp">AUTOGENIUS</h3>
                            <h2 class="text-anime-style-3" data-cursor="-opaque">How AutoGenius Works</h2>
                        </div>
                        <!-- Section Title End -->
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-xl-3 col-md-4 order-lg-1">
                        <!-- Technology Item List Start -->
                        <div class="technology-item-list-1 wow fadeInUp" data-wow-delay="0.2s">
                            <!-- Technology Item Start -->
                            <div class="technology-item">
                                <h3><i class="fa-solid fa-1 text-primary"></i> Contact Us</h3>
                                <p>Call or WhatsApp</p>
                            </div>
                            <!-- Technology Item End -->

                            <!-- Technology Item Start -->
                            <div class="technology-item">
                                <h3><i class="fa-solid fa-2 text-primary"></i> Expert Evaluation</h3>
                                <p>Consultation, inspection or search</p>
                            </div>
                            <!-- Technology Item End -->
                        </div>
                        <!-- Technology Item List End -->
                    </div>

                    <div class="col-xl-6 order-xl-2 col-md-4 order-md-2 order-2">
                        <!-- Technology Image Start -->
                        <div class="technology-image wow fadeInUp" data-wow-delay="0.4s">
                            <figure>
                                <img src="{{ asset('images/our-technology-image.png') }}" alt="">
                            </figure>
                        </div>
                        <!-- Technology Image End -->
                    </div>

                    <div class="col-xl-3 col-md-4 order-xl-3 order-md-3 order-2">
                        <!-- Technology Item List Start -->
                        <div class="technology-item-list-2 wow fadeInUp" data-wow-delay="0.6s">
                            <!-- Technology Item Start -->
                            <div class="technology-item">
                                <h3><i class="fa-solid fa-3 text-primary"></i> Honest Recommendation</h3>
                                <p>Clear advice on what to proceed with</p>
                            </div>
                            <!-- Technology Item End -->

                            <!-- Technology Item Start -->
                            <div class="technology-item">
                                <h3><i class="fa-solid fa-4 text-primary"></i> Smooth Closure</h3>
                                <p>Support through negotiation, delivery & transfer</p>
                            </div>
                            <!-- Technology Item End -->
                        </div>
                        <!-- Technology Item List End -->
                    </div>
                </div>
                <a href="#" class="btn-default mt-4 mx-auto d-block w-fit">Start with an Expert Consultation</a>
            </div>
        </div>
        <!-- our Technology Section End -->

        <!-- Faqs Section Start -->
        <div class="our-faqs mb- 2r mx-0 w-100 pt-0">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-6 col-12">
                        <!-- Faqs Content Start -->
                        <div class="faqs-content">
                            <!-- Section Title Start -->
                            <div class="section-title section-title-center">
                                <h3 class="wow fadeInUp">SERVICE AREA</h3>
                                <h2 class="text-anime-style-3" data-cursor="-opaque">Serving All Over Maharashtra, From Pune</h2>
                                <p>AutoGenius is headquartered in Pune and proudly serves customers across Maharashtra.</p>
                                <p>Including but not limited to:</p>
                                <div class="why-choose-list-ultimate wow fadeInUp mt-2" data-wow-delay="0.4s">
                                    <ul>
                                        <li>Pune & Pimpri-Chinchwad</li>
                                        <li>Mumbai & Thane</li>
                                        <li>Nashik, Kolhapur, Satara</li>
                                        <li>Sambhajinagar (Aurangabad)</li>
                                        <li>Solapur, Jalgaon, Latur</li>
                                        <li>Nagpur, Akola, Amravati</li>
                                    </ul>
                                </div>
                                <a href="tel:+91 86682 28668" class="btn-default mt-4"><i class="fa-solid fa-phone"></i>  +91 8668 22 8668</a>
                            </div>
                            <!-- Section Title End -->
                        </div>
                        <!-- Faqs Content End -->
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="map-wrapper mx-auto">
                            <img src="{{ asset('images/maharashtra-map.svg') }}" alt="Maharashtra Map" class="map-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Faqs Section End -->

        <!-- Why Choose Us Section Start -->
        <div class="why-choose-us-ultimate bg-section mx-0 w-100 ">
            <div class="container-fluid">
                <div class="row no-gutters">
                    <div class="col-xl-6">
                        <!-- Why Choose Us Content Start -->
                        <div class="why-choose-us-content-ultimate">
                            <!-- Section Title Start -->
                            <div class="section-title">
                                <h2 class="text-anime-style-3" data-cursor="-opaque">Why Choose AutoGenius</h2>
                            </div>
                            <!-- Section Title End -->
                            <!-- Why Choose Body Start -->
                            <div class="why-choose-body-ultimate">
                                <table class="table table-bordered table-dark custom_table mb-5">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div>
                                                <img src="{{ asset('images/x.svg') }}" alt="check" class="img-fluid"> Dealers push old stock
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <img src="{{ asset('images/check.svg') }}" alt="check" class="img-fluid"> Independent car experts
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <img src="{{ asset('images/x.svg') }}" alt="check" class="img-fluid"> Odometer & accident fraud
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <img src="{{ asset('images/check.svg') }}" alt="check" class="img-fluid"> 300+ mechanical checkpoints
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <img src="{{ asset('images/x.svg') }}" alt="check" class="img-fluid"> Hesitant to show Car records
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <img src="{{ asset('images/check.svg') }}" alt="check" class="img-fluid"> Complete Service Records & OBD scan
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <img src="{{ asset('images/x.svg') }}" alt="check" class="img-fluid"> Hidden mechanical issues
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <img src="{{ asset('images/check.svg') }}" alt="check" class="img-fluid"> Accident & repaint detection
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <img src="{{ asset('images/x.svg') }}" alt="check" class="img-fluid"> Overpriced deals
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <img src="{{ asset('images/check.svg') }}" alt="check" class="img-fluid"> True market pricing
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div>
                                                <img src="{{ asset('images/x.svg') }}" alt="check" class="img-fluid"> No after-sale support
                                            </div>
                                        </td>
                                        <th>
                                            <div>
                                                <img src="{{ asset('images/check.svg') }}" alt="check" class="img-fluid"> Your Expert Partner Through Every Step
                                            </div>
                                        </th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="m-0">Buying a car worth lakhs or crores?</p>
                            <p>Get an expert on your side.</p>
                            <p>Book Expert Consultation</p>
                            <div class="d-flex flex-wrap gap-3">
                                <a href="https://wa.me/+918007500740?text=Hi%20AutoGenius%2C%0AI%27d%20like%20expert%20guidance%20regarding%20a%20car." class="btn-primary w-fit" target="_blank"><i class="fa-brands fa-whatsapp"></i> WhatsApp AutoGenius</a>
                                <a href="tel:+91 86682 28668" class="btn-default w-fit"><i class="fa-solid fa-phone"></i>  +91 8668 22 8668</a>
                            </div>
                            <!-- Why Choose Body End -->
                        </div>
                        <!-- Why Choose Us Content End -->
                    </div>

                    <div class="col-xl-6">
                        <!-- Why Choose Image Start -->
                        <div class="why-choose-image-ultimate">
                            <figure class="image-anime">
                                <img src="{{ asset('images/car-test.jpg') }}" alt="">
                            </figure>
                        </div>
                        <!-- Why Choose Image End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Why Choose Us Section End -->

        <div class="why-choose-us mb- 2r mx-0 w-100">
            <div class="container">
                <div class="col-lg-12">
                    <!-- Hero Slider Start -->
                    <div class="company-logo-slider">
                        <p>Experience across the world’s leading automotive brands</p>
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <!-- Hero Slide Start -->
                                <div class="swiper-slide">
                                    <div class="company-logo">
                                        <img src="{{ asset('images/company-logo-1.svg') }}" alt="">
                                    </div>
                                </div>
                                <!-- Hero Slide End -->

                                <!-- Hero Slide Start -->
                                <div class="swiper-slide">
                                    <div class="company-logo">
                                        <img src="{{ asset('images/company-logo-2.svg') }}" alt="">
                                    </div>
                                </div>
                                <!-- Hero Slide End -->

                                <!-- Hero Slide Start -->
                                <div class="swiper-slide">
                                    <div class="company-logo">
                                        <img src="{{ asset('images/company-logo-3.svg') }}" alt="">
                                    </div>
                                </div>
                                <!-- Hero Slide End -->

                                <!-- Hero Slide Start -->
                                <div class="swiper-slide">
                                    <div class="company-logo">
                                        <img src="{{ asset('images/company-logo-4.svg') }}" alt="">
                                    </div>
                                </div>
                                <!-- Hero Slide End -->

                                <!-- Hero Slide Start -->
                                <div class="swiper-slide">
                                    <div class="company-logo">
                                        <img src="{{ asset('images/company-logo-5.svg') }}" alt="">
                                    </div>
                                </div>
                                <!-- Hero Slide End -->

                                <!-- Hero Slide Start -->
                                <div class="swiper-slide">
                                    <div class="company-logo">
                                        <img src="{{ asset('images/company-logo-6.svg') }}" alt="">
                                    </div>
                                </div>
                                <!-- Hero Slide End -->
                            </div>
                        </div>
                    </div>
                    <!-- Hero Slider End -->
                </div>
            </div>
        </div>

        <!-- About Us Section Start -->
        <div class="about-us bg-section mb-2r mx-0 w-100">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-4 col-xl-3">
                        <div class="logo mt-5 mb-3">
                            <img src="{{ asset('images/logo-icon.png') }}" class="img-fluid py-3 w-75 mx-auto d-block" alt="">
                        </div>
                        <!-- Section Sub Title End -->
                    </div>

                    <div class="col-xxl-8 col-xl-9">
                        <!-- About Us Content Start -->
                        <div class="about-us-content">
                            <!-- Section Title Start -->
                            <div class="section-title">
                                <h2 class="text-effect" data-cursor="-opaque">Protecting Buyers from Costly Car Mistakes</h2>
                                <p>Most buyers discover issues after the purchase. <br> At <span>AutoGenius</span>, we help identify hidden problems early — so you avoid unexpected expenses and make the right decision before committing your money.</p>
                                <p>Most regrets in car buying start with “I thought it was fine.”</p>
                            </div>
                            <!-- Section Title End -->

                            <!-- About Us Body Start -->
                            <div class="about-us-body wow fadeInUp" data-wow-delay="0.2s">
                                <!-- About Us Button Start -->
                                <div class="about-us-btn">
                                    <a href="javascript:void(0)" class="btn-default">Talk to an Expert Before You Decide</a>
                                </div>
                                <!-- About Us Button End -->

                                <!-- About Contact Item List Start -->
                                <div class="about-contact-items-list d-none">
                                    <!-- About Contact Item Start -->
                                    <div class="about-contact-item">
                                        <div class="icon-box">
                                            <img src="{{ asset('images/icon-clock-accent.svg') }}" alt="">
                                        </div>
                                        <div class="about-contact-item-content">
                                            <h3>Opening Hours</h3>
                                            <p>Monday - Saturday: 10 AM - 8 PM</p>
                                        </div>
                                    </div>
                                    <!-- About Contact Item End -->

                                    <!-- About Contact Item Start -->
                                    <div class="about-contact-item">
                                        <div class="icon-box">
                                            <img src="{{ asset('images/icon-phone-accent.svg') }}" alt="">
                                        </div>
                                        <div class="about-contact-item-content">
                                            <h3>Contact Info</h3>
                                            <p><a href="tel:+918007500740">+91 80075 00740</a></p>
                                        </div>
                                    </div>
                                    <!-- About Contact Item End -->
                                </div>
                                <!-- About Contact Item List End -->
                            </div>
                            <!-- About Us Body End -->
                        </div>
                        <!-- About Us Content End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- About Us Section End -->

        <!-- Our Approach Section Start -->
        <div class="our-approach bg-section mx-0 w-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                        <!-- Approach Image Box Start -->
                        <div class="approach-image-box wow fadeInUp" data-wow-delay="0.2s">
                            <!-- Approach Image Start -->
                            <div class="approach-image-box-1 w-100">
                                <div id="carouselExample" class="carousel slide carousel-fade">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="approach-img">
                                                <figure class="image-anime">
                                                    <img src="{{ asset('images/1.jpg') }}" alt="">
                                                </figure>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="approach-img">
                                                <figure class="image-anime">
                                                    <img src="{{ asset('images/2.jpg') }}" alt="">
                                                </figure>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="approach-img">
                                                <figure class="image-anime">
                                                    <img src="{{ asset('images/new-car-con.jpg') }}" alt="">
                                                </figure>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>

                            </div>
                            <!-- Approach Image End -->
                        </div>
                        <!-- Approach Image Box End -->
                    </div>
                    <div class="col-xl-6">
                        <!-- Approach Content Start -->
                        <div class="approach-content">
                            <!-- Section Title Start -->
                            <div class="section-title">
                                <h3 class="wow fadeInUp">About AutoGenius</h3>
                                <h2 class="text-anime-style-3" data-cursor="-opaque">AutoGenius was founded with one simple belief:</h2>
                                <p class="wow fadeInUp" data-wow-delay="0.2s">Car buyers deserve expert guidance — not sales pressure. <br> Over the years, we saw too many buyers lose money, peace of mind, and trust due to:</p>
                            </div>
                            <!-- Section Title End -->

                            <div class="why-choose-list-ultimate wow fadeInUp mt-2 mb-2" data-wow-delay="0.4s">
                                <ul>
                                    <li>Hidden vehicle issues</li>
                                    <li>Poor or biased advice</li>
                                    <li>Dealer-driven decisions</li>
                                    <li>Incomplete or misleading information</li>
                                </ul>
                            </div>
                            <br>
                            <p>AutoGenius exists to stand firmly on the buyer’s side.</p>
                            <p>We don’t sell cars. <br> We help people buy the right one.</p>
                            <a href="javascript:void(0)" class="btn-default mt-3">Speak to an AutoGenius Expert</a>
                        </div>
                        <!-- Approach Content End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Our Approach Section End -->

        <!-- What We Do Section Start -->
        <div class="what-we-do-ultimate">
            <div class="container">
                <div class="row section-row">
                    <div class="col-lg-12">
                        <!-- Section Title Start -->
                        <div class="section-title section-title-center">
                            <h3 class="wow fadeInUp">WHY WE FOUNDED AUTOGENIUS</h3>
                        </div>
                        <!-- Section Title End -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <!-- What We Image Start -->
                        <div class="what-we-image-ultimate wow fadeInUp">
                            <figure class="image-anime">
                                <img src="{{ asset('images/img-1.jpg') }}" alt="">
                            </figure>
                        </div>
                        <!-- What We Image End -->
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <!-- What We Item Box Start -->
                        <div class="what-we-item-box-ultimate wow fadeInUp" data-wow-delay="0.2s">
                            <!-- What We Client Box Start -->
                            <div class="what-we-client-box-ultimate">
                                <!-- Happy Client Content Start -->
                                <div class="what-we-client-content-ultimate">
                                    <h3>Most car problems don’t start on the road - they start at the time of purchase.</h3>
                                </div>
                                <!-- Happy Client Content End -->
                                <div class="why-choose-list-ultimate w-100 wow fadeInUp mt-3 mb-2" data-wow-delay="0.4s">
                                    <p class="mb-2">AutoGenius was created to:</p>
                                    <ul>
                                        <li>Save buyers from bad car decisions</li>
                                        <li>Bring transparency into car buying</li>
                                        <li>Replace guesswork with expert analysis</li>
                                        <li>Ensure money is spent wisely, not emotionally</li>
                                    </ul>
                                </div>
                                <br />
                                <p>A car should add comfort to your life - not stress.</p>
                            </div>
                            <!-- What We Client Box End -->
                        </div>
                        <!-- What We Item Box End -->
                    </div>

                    <div class="col-xl-3 col-md-12">
                        <!-- What We Image Start -->
                        <div class="what-we-image-ultimate wow fadeInUp">
                            <figure class="image-anime">
                                <img src="{{ asset('images/car-cust.jpg') }}" alt="">
                            </figure>
                        </div>
                        <!-- What We Image End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- What We Do Section End -->
@endsection
