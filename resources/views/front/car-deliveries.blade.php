@extends('layouts.front')

@section('title', $page->meta_title ?? 'Instagram Feed')
@section('meta_description', $page->meta_description ?? '')
@section('meta_keywords', $page->meta_keywords ?? '')

@section('breadcrumbs')
<li class="breadcrumb-item active" aria-current="page">Instagram Feed</li>
@endsection

@section('header')
    <div class="page-header bg-section parallaxie1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header-box text-center">
                        <h1 class="text-anime-style-3" data-cursor="-opaque" aria-label="instagram feed" style="perspective: 400px;">Instagram Feed</h1>
                        <p class="text-white">Follow our journey and stay updated with our latest posts.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<section class="instagram-feed-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="elfsight-app-b952bdb2-6d02-4e32-a0a5-d39a868503f3" data-elfsight-app-lazy></div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://elfsightcdn.com/platform.js" async></script>
@endpush