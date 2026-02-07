@extends('layouts.front')

@section('content')
    <div class="page-header bg-section parallaxie1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque" aria-label="Contact Us" style="perspective: 400px;">Create an account</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="page-contact-us">
        <div class="container">
            <div class="contact-form col-md-6 mx-auto">
                <div class="contact-form-title mb-2 text-center">
                    <h3 class="text-anime-style-3 mb-4" data-cursor="-opaque">Create an account</h3>
                </div>
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <x-input-label for="name" class="form-label" :value="__('Name')" />
                                <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <x-input-label for="email" class="form-label" :value="__('Email')" />
                                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <x-input-label for="password" class="form-label" :value="__('Password')" />
                                <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <x-input-label for="password_confirmation" class="form-label" :value="__('Confirm Password')" />
                                <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <x-primary-button class="btn-default text-center w-25 mx-auto justify-content-center">{{ __('Register') }}</x-primary-button>
                            <div class="flex items-center justify-content-center text-center mt-4">
                                <a class="text-primary" href="{{ route('login') }}">
                                    {{ __('Already registered?') }}
                                </a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        $(document).ready(function () {
            $('#registerForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password" // Matches the ID of the password field
                    }
                },
                messages: {
                    password_confirmation: {
                        equalTo: "The passwords do not match."
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
                              .removeClass('border-danger1');
                },
                unhighlight: function (element) {
                    $(element).removeClass('border-danger0')
                              .addClass('border-danger1');
                }
            });
        });
    </script>
    @endpush
@endsection
