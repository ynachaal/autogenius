@extends('layouts.front')

@section('content')
    <div class="page-header bg-section parallaxie1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque" aria-label="Contact Us" style="perspective: 400px;">Login</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="page-contact-us">
        <div class="container">
            <div class="contact-form col-md-6 mx-auto">
                <div class="contact-form-title mb-2 text-center">
                    <h3 class="text-anime-style-3 mb-4" data-cursor="-opaque">Login</h3>
                </div>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    <div class="form-group mb-4">
                        <x-input-label class="form-label" for="email" :value="__('Email')" />
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" :placeholder="__('Email')" required
                            autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="form-group mb-4">
                        <x-input-label class="form-label" for="password" :value="__('Password')" />
                        <x-text-input id="password" class="form-control" type="password" name="password" :placeholder="__('Password')" required
                            autocomplete="current-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="form-check mb-4">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-primary">{{ __('Forgot your password?') }}</a>
                        @endif
                    </div>
                    <x-primary-button class="btn-default text-center w-25 mx-auto justify-content-center">{{ __('Log in') }}</x-primary-button>
                </form>
            </div>
        </div>
    </section>
   @push('scripts')
<script>
    $(document).ready(function () {
        $('#loginForm').validate({
            // Define rules
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                }
            },

            // Define the element and the class applied to it
            errorElement: 'span',

            // FIX: Use a simple class name here if the complex one fails,
            // or ensure it is wrapped correctly.
            errorClass: 'validation-error',

            // Use the 'errorPlacement' function to apply Tailwind classes dynamically
            errorPlacement: function(error, element) {
                error.addClass('small text-danger mt-2 d-block');
                error.insertAfter(element);
            },

            highlight: function (element) {
                $(element).addClass('border-danger')
                          .removeClass('border-danger1');
            },
            unhighlight: function (element) {
                $(element).removeClass('border-danger')
                          .addClass('border-danger1');
            }
        });
    });
</script>
@endpush
@endsection
