@extends('layouts.front')

@section('title', $page->title)

@section('content')
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