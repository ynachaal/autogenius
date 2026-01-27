@extends('layouts.front')

@section('title', $page->title)

@section('meta_description', $page->meta_description ?? '')
@section('meta_keywords', $page->meta_keywords ?? '')



@section('content')
<div class="page-header bg-section parallaxie1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Page Header Box Start -->
                <div class="page-header-box">
                    <h1 class="text-anime-style-3" data-cursor="-opaque" aria-label="about us" style="perspective: 400px;">{{ $page->title }}</h1>
                </div>
                <!-- Page Header Box End -->
            </div>
        </div>
    </div>
</div>
    <section class="page-detail py-5">
        <div class="container">
            {{-- Page Title --}}
            <h1 class="mb-4">{{ $page->title }}</h1>

            {{-- Page Content --}}
            <div class="page-content">
                {!! $page->content !!}
            </div>
        </div>
    </section>
@endsection
