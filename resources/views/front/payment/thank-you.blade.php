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
                    <p>{{ $response }}</p>
                </div>
            </div>
        </div>
    </section>


@endsection
