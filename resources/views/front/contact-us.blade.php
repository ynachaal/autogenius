@extends('layouts.front')

@section('title', 'Contact Us')

@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">Contact Us</li>
@endsection

@section('header')
    <section class="inner-header py-5">
        <div class="container">
            <div class="heading text-center">
        <h1>Contact Us</h1>
        <p>We’d love to hear from you! Fill out the form below and we’ll get back to you shortly.</p>
            </div>
    </div>
</section>
@endsection

@section('content')
<section class="blog-article py-5">
    <div class="content-wrapper container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg p-4 p-md-5">

                    {{-- Session Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success mb-4">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('site.contactUs.submit') }}" id="contactForm">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-500">{{ __('Full Name') }}</label>
                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autofocus>
                            @error('name')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-500">{{ __('Email Address') }}</label>
                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label fw-500">{{ __('Your Message') }}</label>
                            <textarea id="message" class="form-control @error('message') is-invalid @enderror" name="message" rows="5">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn_primary w-100 py-2">{{ __('Send Message') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $("#contactForm").validate({
        rules: {
            name: { required: true, minlength: 2 },
            email: { required: true, email: true },
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
            message: {
                required: "Please enter your message.",
                minlength: "Your message must be at least 10 characters long."
            }
        },
        errorElement: 'div',
        errorPlacement: function(error, element) {
            error.addClass('text-danger mt-1 small');
            error.insertAfter(element);
        },
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });
});
</script>
@endpush
