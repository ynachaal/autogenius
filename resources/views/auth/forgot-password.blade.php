@extends('layouts.front')

@section('content')
    <section class="page-contact-us">
        <div class="container">
            <div class="contact-form col-md-6 mx-auto">
                <div class="contact-form-title mb-2 text-center">
                    <h3 class="text-anime-style-3 mb-4" data-cursor="-opaque">Forgot your password?</h3>
                    <p>{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
                    @csrf
                    <div class="form-group mb-4">
                        <x-input-label class="form-label" for="email" :value="__('Email')" />
                        <x-text-input id="email" class="form-control" type="email" name="forgot_email" :value="old('forgot_email')" :placeholder="__('Email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="btn-default text-center  mx-auto justify-content-center">
                            {{ __('Email Password Reset Link') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        $(document).ready(function () {
            $('#forgotPasswordForm').validate({
                rules: {
                    forgot_email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address."
                    }
                },
                errorElement: 'span',
                errorClass: 'jquery-validation-error',
                errorPlacement: function(error, element) {
                    error.addClass('small text-danger mt-2 d-block');
                    error.insertAfter(element);
                },
                highlight: function (element) {
                    $(element).addClass('border-danger')
                              .removeClass('border-gray-300 dark:border-gray-700');
                },
                unhighlight: function (element) {
                    $(element).removeClass('border-danger')
                              .addClass('border-gray-300 dark:border-gray-700');
                }
            });
        });
    </script>
    @endpush
@endsection
