@extends('layouts.front')

@section('title', $page->meta_title ?? '')

@section('meta_description', $page->meta_description ?? '')
@section('meta_keywords', $page->meta_keywords ?? '')

@section('content')
<div class="our-approach bg-section about_section mt-5 mb-3">
    <div class="container">
        <div class="row align-items-center gy-4">
            <x-slider-carousel :sliders="$sliders" carousel-id="homeSlider" />
            <div class="col-xl-6">
                <div class="approach-content">
                    <div class="section-title mb-2">
                        <h3 class="wow fadeInUp">About AutoGenius</h3>
                    </div>
                    {!! $page->content ?? '' !!}
                </div>
            </div>
        </div>
    </div>
</div>
    <section class="about-us bg-section principles mb-2r pt-5 pb-4">
        <div class="container">
            <div class="about-us-content">
                {!! $page->sub_content ?? '' !!}
            </div>
        </div>
    </section>
@endsection
