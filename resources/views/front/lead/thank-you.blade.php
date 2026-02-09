@extends('layouts.front')

@section('title', 'Thank You - AutoGenius')

@section('content')
    <div class="page-header bg-section parallaxie1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque" aria-label="Thank You"
                            style="perspective: 400px;">
                            Thank You
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="page-detail py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="page-content text-center">
                    <p>{{ $response }}</p>
                </div>
            </div>
        </div>
    </section>


@endsection