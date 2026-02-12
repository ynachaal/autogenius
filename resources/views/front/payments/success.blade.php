@extends('layouts.front')

@section('title', 'Thank You - AutoGenius')

@section('content')

    <section class="page-detail py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="page-content text-center">
                    <div class="thank-you-img">
                        <img src="{{ asset('images/thank-you.svg') }}" alt="thank you" class="img-fluid">
                    </div>
                    <div class="section-title section-title-center thank-you">
                        <h2>Thank You</h2>
                    </div>
                    <p>
                        {!! session('message') ?? 'Your Inquiry Has Been Successfully Received. We will get back to you shortly.' !!}
                    </p>
                </div>
            </div>
        </div>
    </section>


@endsection