@extends('layouts.front')

@section('title', $page->meta_title ?? 'Book a Consultation')

@section('meta_description', $page->meta_description ?? '')
@section('meta_keywords', $page->meta_keywords ?? '')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Consultation</li>
@endsection

@section('header')
    <div class="page-header bg-section parallaxie1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque" aria-label="consultation"
                            style="perspective: 400px;">Book a Consultation</h1>
                        <p class="text-white m-0">Schedule a session with our experts. Please fill in the details below.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="consultation-section py-5">
        <div class="content-wrapper container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="contact-form">
                        <div class="contact-form-title text-center">
                            <h3 class="text-anime-style-3" data-cursor="-opaque" style="perspective: 400px;">Book a
                                Consultation</h3>
                        </div>
                        {{-- Session Messages --}}
                        @if (session('success'))
                            <div class="alert alert-success mb-4">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger mb-4">{{ session('error') }}</div>
                        @endif
                        <form method="POST" action="{{ route('frontend.consultation.store') }}" id="consultationForm">
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
                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" id="phone" placeholder="{{ __('Phone Number') }}"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 mb-4">
                                    <input type="date" id="preferred_date" name="preferred_date"
                                        value="{{ old('preferred_date') }}" placeholder="{{ __('Preferred Date') }}"
                                        class="form-control @error('preferred_date') is-invalid @enderror">

                                    {{-- Small instruction --}}
                                    <small style="color:white !important" class="text-muted d-block mt-1">Select your preferred consultation date.</small>

                                    {{-- Validation error --}}
                                    @error('preferred_date')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-4">
                                    <input placeholder="{{ __('Subject') }}" type="text" id="subject"
                                        class="form-control @error('subject') is-invalid @enderror" name="subject"
                                        value="{{ old('subject') }}">
                                    @error('subject')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12 mb-4">
                                    <textarea placeholder="{{ __('Additional Information') }}" id="message"
                                        class="form-control @error('message') is-invalid @enderror" name="message"
                                        rows="4">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12 mb-4">
                                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"
                                        data-theme="dark"></div>
                                </div>
                                <div class="alert alert-info text-center mb-4 d-none">
                                    <strong>Consultation Fee:</strong> ₹99<br>
                                    You will be redirected to secure payment after submitting this form.
                                </div>
                                <div class="col-lg-12 text-center">
                                    <div class="contact-form-btn mt-4">
                                        <!-- <button type="submit"
                                            class="btn btn-primary px-5 py-3 fw-semibold d-inline-flex align-items-center gap-2">
                                            <i class="fa fa-lock"></i>
                                            Proceed to Pay ₹99
                                        </button> -->
                                        <button type="submit"
                                            class="btn-default text-center w-fit">
                                          
                                            Submit
                                        </button>
                                    </div>
                                </div>

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
        $(document).ready(function () {
            $("#consultationForm").validate({
                rules: {
                    name: { required: true, minlength: 2 },
                    email: { required: true, email: true },
                    phone: { required: true, minlength: 7, maxlength: 20 },
                    subject: { required: true, minlength: 5 },
                    preferred_date: { required: true, date: true },
                    message: { required: false, minlength: 10 }
                },
                messages: {
                    name: {
                        required: "Please enter your full name.",
                        minlength: "Your name must consist of at least 2 characters."
                    },
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address."
                    },
                    phone: {
                        required: "Please enter your phone number.",
                        minlength: "Please enter a valid phone number."
                    },
                    subject: {
                        required: "Please specify the subject of consultation."
                    },
                    preferred_date: {
                        required: "Please select a preferred date."
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
                    const turnstileResponse = $('[name="cf-turnstile-response"]').val();

                    if (!turnstileResponse) {
                        alert("Please complete the security check.");
                        return false;
                    }

                    $(form).find('button[type="submit"]')
                        .prop('disabled', true)
                        .text('Redirecting to payment...');

                    form.submit();
                }
            });
        });
    </script>
@endpush