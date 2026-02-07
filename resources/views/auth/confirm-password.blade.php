@extends('layouts.front')

@section('content')
    <div class="page-header bg-section parallaxie1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque" aria-label="Contact Us" style="perspective: 400px;">Forgot your password</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="page-contact-us">
        <div class="container">
            <div class="contact-form col-md-6 mx-auto">
                <div class="contact-form-title mb-2 text-center">
                    <h3 class="text-anime-style-3 mb-4" data-cursor="-opaque">Confirm your password</h3>
                    <p>{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>
                </div>
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <!-- Password -->
                    <div class="form-group mb-4">
                        <x-input-label for="password" class="form-label" :value="__('Password')" />
                        <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <x-primary-button class="btn-default text-center  mx-auto justify-content-center">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </section>
@endsection
