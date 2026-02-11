@extends('layouts.front')

@section('title', $page->meta_title ?? '')

@section('meta_description', $page->meta_description ?? '')
@section('meta_keywords', $page->meta_keywords ?? '')

<div class="our-approach bg-section mx-0 w-100">
    <div class="container">
        <div class="row align-items-center">
            <x-slider-carousel :sliders="$sliders" carousel-id="homeSlider" />
            <div class="col-xl-6">
                <div class="approach-content">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">About AutoGenius</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">
                            {{ $data['about']['heading'] ?? 'AUTOGENIUS WAS FOUNDED WITH ONE SIMPLE BELIEF:' }}
                        </h2>

                        @if(isset($data['about']['description1']))
                            <p class="wow fadeInUp" data-wow-delay="0.2s">
                                {!! nl2br(e($data['about']['description1'])) !!}
                            </p>
                        @endif
                    </div>
                    <div class="why-choose-list-ultimate wow fadeInUp mt-2 mb-2" data-wow-delay="0.4s">
                        <ul>
                            @php
                                // Pulling market_issue_1, market_issue_2, etc.
                                $issues = array_filter($data['about'], function ($key) {
                                    return str_contains($key, 'market_issue_');
                                }, ARRAY_FILTER_USE_KEY);
                                ksort($issues);
                            @endphp

                            @foreach($issues as $issue)
                                <li>{{ $issue }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <br>

                    {{-- Dynamic Mission Text --}}
                    @if(isset($data['about']['mission_text']))
                        <p>{{ $data['about']['mission_text'] }}</p>
                    @endif

                    {{-- Dynamic Closing Hook --}}
                    @if(isset($data['about']['closing_hook']))
                        @php
                            // Splitting "We don’t sell cars. We help people buy the right one." into two lines
                            $hooks = explode('. ', $data['about']['closing_hook']);
                        @endphp
                        <p>
                            @foreach($hooks as $hook)
                                {{ $hook }}{{ !$loop->last ? '.' : '' }} @if(!$loop->last) <br> @endif
                            @endforeach
                        </p>
                    @endif

                    <a href="tel:{{ config('settings.phone', '') }}" class="btn-default mt-3">
                        Speak to an AutoGenius Expert
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>