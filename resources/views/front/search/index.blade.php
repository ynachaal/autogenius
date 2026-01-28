@extends('layouts.front')

@section('header')
    <div class="page-header bg-section parallaxie1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="text-anime-style-3 mb-4" data-cursor="-opaque">Search Results</h1>

                    {{-- Compact Search Bar --}}
                    <form action="{{ url('/search') }}" method="GET" id="searchForm" class="mx-auto"
                        style="max-width: 500px;">
                        <div class="input-group">
                            <input type="text" value="{{ request('q') }}" name="q" id="q"
                                class="form-control border-0 py-3 px-4 @error('q') is-invalid @enderror"
                                placeholder="What are you looking for?" required>
                            <button class="btn btn-warning px-4" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                        <div id="q-error-container">
                            @error('q')
                                <div class="text-warning mt-2 text-start small fw-bold text-uppercase">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- Main content area changed to dark background to match the image --}}
    <section class="py-5 bg-black text-white min-vh-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">

                    {{-- Summary Line --}}
                    <div class="mb-5">
                        <h2 class="text-uppercase fw-bold mb-3" style="letter-spacing: 1px;">Search Results</h2>
                        <p class="text-secondary small text-uppercase fw-bold">
                            Found {{ $data['count'] }} results for "{{ $data['query'] }}"
                        </p>
                    </div>

                    {{-- Results List --}}
                    @if($data['count'] > 0)
                        <div class="results-container">
                            @foreach($data['results'] as $item)
                                <div class="py-4 border-bottom border-secondary search-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="pe-4">
                                            <span class="text-brand fw-bold text-uppercase mb-2 d-block" style="font-size: 12px; letter-spacing: 1px;">
                                                {{ $item->result_type == 'services' ? 'Service' : 'Information' }}
                                            </span>
                                            <h3 class="h4 fw-normal text-white mb-2">
                                                <a href="{{ $item->result_type == 'services' ? route('services.show', $item->slug) : route('pages.show', $item->slug) }}"
                                                   class="text-decoration-none text-white hover-brand">
                                                    {{ $item->title }}
                                                </a>
                                            </h3>
                                            <p class="text-secondary mb-0 small">Click to view details about this {{ $item->result_type }}.</p>
                                        </div>
                                        <a href="{{ $item->result_type == 'services' ? route('services.show', $item->slug) : route('pages.show', $item->slug) }}"
                                           class="btn btn-outline-brand rounded-circle d-flex align-items-center justify-content-center" 
                                           style="width: 45px; height: 45px;">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-5 d-flex justify-content-center custom-pagination">
                            {{ $data['results']->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="text-secondary">No results found. Please try a different keyword.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

<style>
    .bg-black {
        background-color: #000000 !important;
    }
    .text-brand {
        color: var(--brand-color) !important;
    }
    .btn-brand {
        background-color: var(--brand-color);
        color: #000;
        border: none;
        font-weight: bold;
    }
    .btn-outline-brand {
        border: 1px solid var(--brand-color);
        color: var(--brand-color);
    }
    .btn-outline-brand:hover {
        background-color: var(--brand-color);
        color: #000;
    }
    .hover-brand:hover {
        color: var(--brand-color) !important;
        transition: 0.3s;
    }
    .search-item {
        transition: all 0.3s ease;
    }
    .search-item:hover {
        background-color: #111;
        padding-left: 15px;
    }
</style>