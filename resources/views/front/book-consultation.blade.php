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
                        <p class="text-white">Schedule a session with our experts. Please fill in the details below.</p>
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
                    <div class="card shadow-lg p-4 p-md-5">

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
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-500">{{ __('Full Name') }}</label>
                                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" autofocus>
                                    @error('name')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-500">{{ __('Email Address') }}</label>
                                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-500">{{ __('Phone Number') }}</label>
                                    <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="preferred_date" class="form-label fw-500">{{ __('Preferred Date') }}</label>
                                    <input type="date" id="preferred_date" class="form-control @error('preferred_date') is-invalid @enderror"
                                        name="preferred_date" value="{{ old('preferred_date') }}">
                                    @error('preferred_date')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label fw-500">{{ __('Subject') }}</label>
                                <input type="text" id="subject" class="form-control @error('subject') is-invalid @enderror"
                                    name="subject" value="{{ old('subject') }}">
                                @error('subject')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label fw-500">{{ __('Additional Information') }}</label>
                                <textarea id="message" class="form-control @error('message') is-invalid @enderror"
                                    name="message" rows="4">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn_primary w-100 py-2">{{ __('Request Consultation') }}</button>
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
                }
            });
        });
    </script>
@endpush