@extends('layouts.front')

@section('title', $page->meta_title ?? '')

@section('meta_description', $page->meta_description ?? '')
@section('meta_keywords', $page->meta_keywords ?? '')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
@endsection

@section('header')
    <div class="page-header bg-section parallaxie1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque" aria-label="about us"
                            style="perspective: 400px;">Contact Us</h1>
                        <p class="text-white">We’d love to hear from you! Fill out the form below and we’ll get back to you
                            shortly.</p>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="page-contact-us">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="contact-us-content">
                        <div class="section-title">
                            <h3 class="wow fadeInUp">Get in touch</h3>
                            <h2 class="text-anime-style-3">Find Your Perfect Car, Faster</h2>
                            <p class="wow fadeInUp">Reach out today and discover amazing deals on new and pre-owned cars.
                            </p>
                        </div>
                        <div class="contact-item-box-list">
                            <div class="opening-hours-box wow fadeInUp">
                                <div class="opening-hours-content">
                                    <h3>Open Hours:</h3>
                                    <p>Our flexible opening and closing hours are designed to fit your lifestyle.</p>
                                    <ul>
                                        <li><span>Mon - Sat:</span> 10:00AM - 06:30PM</li>
                                        <li><span>Sunday:</span> Closed</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="contact-info-box wow fadeInUp animated">
                                <div class="contact-info-item">
                                    <h3>Call Us!</h3>
                                    <p><a href="tel:{{config('settings.phone', '') }}"
                                            class="fw-normal">{{config('settings.phone', '') }}</a></p>
                                </div>
                                <div class="contact-info-item">
                                    <h3>E-mail Us!</h3>
                                    <p><a
                                            href="mailto:{{ config('settings.contact_email', '') }}">{{ config('settings.contact_email', '') }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="contact-form">
                        <div class="contact-form-title">
                            <h3 class="text-anime-style-3" data-cursor="-opaque" style="perspective: 400px;">Contact Us for
                                enrollment</h3>
                        </div>
                        {{-- Session Messages --}}
                        @if (session('success'))
                            <div class="alert alert-success mb-4">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger mb-4">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('frontend.contact.store') }}" id="contactForm">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 mb-4">
                                    <input placeholder="{{ __('Full Name') }}" type="text" id="name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" autofocus>
                                    @error('name')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 mb-4">
                                    <input placeholder="{{ __('Email Address') }}" type="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12 mb-4">
                                    <input placeholder="{{ __('Mobile Number') }}" type="text" id="mobile_no"
                                        class="form-control @error('mobile_no') is-invalid @enderror" name="mobile_no"
                                        value="{{ old('mobile_no') }}">
                                    @error('mobile_no')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12 mb-5">
                                    <textarea placeholder="{{ __('Your Message') }}" id="message"
                                        class="form-control @error('message') is-invalid @enderror" name="message"
                                        rows="5">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12 mb-4">
                                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"
                                        data-theme="dark"></div>
                                    @error('cf-turnstile-response')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <div class="contact-form-btn">
                                        <button type="submit"
                                            class="btn-default text-center w-fit">{{ __('Send Message') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="google-map-iframe">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3783.507321064284!2d73.90389727525861!3d18.505962782584792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2c6c71ca3ae15%3A0x96e26438da383645!2sAutoGenius%20Private%20Limited!5e0!3m2!1sen!2sin!4v1769671107796!5m2!1sen!2sin"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            {{-- Gallery --}}
            <div class="row gallery-items page-gallery-box mt-5">
                <div class="col-lg-4 col-6">
                    <div class="photo-gallery wow fadeInUp">
                        <a href="https://autogenous.wlslab.com/storage/services/YUEbadQDylRc8KZqTKC1i2R44LZi7zWnANm80AlF.jpg"
                            data-cursor-text="View">
                            <figure class="image-anime">
                                <img src="https://autogenous.wlslab.com/storage/services/YUEbadQDylRc8KZqTKC1i2R44LZi7zWnANm80AlF.jpg"
                                    alt="">
                            </figure>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="photo-gallery wow fadeInUp">
                        <a href="https://autogenous.wlslab.com/storage/services/WRfMt6DVnqiJKpLIYrRNYFo0TLYdRt7p9nA2pDoS.jpg"
                            data-cursor-text="View">
                            <figure class="image-anime">
                                <img src="https://autogenous.wlslab.com/storage/services/WRfMt6DVnqiJKpLIYrRNYFo0TLYdRt7p9nA2pDoS.jpg"
                                    alt="">
                            </figure>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="photo-gallery wow fadeInUp">
                        <a href="https://autogenous.wlslab.com/storage/services/kKuUC1C9J2BGmCNCM7YYXOmb4u0N4Qgxf7ZKFh6X.jpg"
                            data-cursor-text="View">
                            <figure class="image-anime">
                                <img src="https://autogenous.wlslab.com/storage/services/kKuUC1C9J2BGmCNCM7YYXOmb4u0N4Qgxf7ZKFh6X.jpg"
                                    alt="">
                            </figure>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $("#contactForm").validate({
                rules: {
                    name: { required: true, minlength: 2 },
                    email: { required: true, email: true },
                    mobile_no: { required: true, minlength: 7, maxlength: 20 },
                    message: { required: true, minlength: 10 }
                },
                messages: {
                    name: {
                        required: "Please enter your full name.",
                        minlength: "Your name must consist of at least 2 characters."
                    },
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address (e.g., user@example.com)."
                    },
                    mobile_no: {
                        minlength: "Please enter a valid mobile number.",
                        maxlength: "Mobile number is too long."
                    },
                    message: {
                        required: "Please enter your message.",
                        minlength: "Your message must be at least 10 characters long."
                    }
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass('text-danger mt-1 small');
                    error.insertAfter(element);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                submitHandler: function (form) {
                    // Check if Turnstile has produced a response token
                    const turnstileResponse = $('[name="cf-turnstile-response"]').val();

                    if (!turnstileResponse) {
                        // If they haven't checked the box, show an alert or a message
                        alert("Please verify that you are not a robot.");
                        return false;
                    }

                    // Validated and verified, now submit
                    form.submit();
                }
            });
        });
    </script>
@endpush