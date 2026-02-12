@extends('layouts.front')

@section('title', $page->meta_title ?? '')
@section('meta_description', $page->meta_description ?? '')
@section('meta_keywords', $page->meta_keywords ?? '')

@section('content')
    <div class="modal fade" id="testimonialModal" tabindex="-1" aria-labelledby="testimonialModalLabel" aria-hidden="true"
        data-bs-theme="dark">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <div class="modal-header border-0 p-2 px-3">
                    <h1 class="modal-title h6 fw-normal" id="modal-author-name"></h1>
                    <button type="button" class="btn-close opacity-100 shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="modal-video-wrapper" class="d-none">
                        <div class="ratio ratio-16x9">
                            <iframe id="modal-iframe" src="" title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                    </div>

                    <div id="modal-image-wrapper" class="d-none">
                        <img id="modal-img" src="" class="img-fluid w-100" alt="Testimonial">
                    </div>

                    <div class="p-3 bg-white text-black">
                        <p id="modal-description" class="small m-0 fw-normal"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="page-testimonials">
        <div class="container">
            <div class="page-header-box mb-4 text-center">
                <h1 class="text-anime-style-3" data-cursor="-opaque" style="perspective: 400px;">Testimonials</h1>
            </div>
            <div class="row g-2">
                @forelse($testimonials as $testimonial)
                    @php
                        // Extract YouTube ID
                        $videoId = '';
                        if ($testimonial->youtube_url) {
                            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $testimonial->youtube_url, $match);
                            $videoId = $match[1] ?? '';
                        }
                    @endphp

                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="service-item-prime wow fadeInUp" data-wow-delay="0.1s">
                            <div class="service-item-image-prime">
                                <a href="javascript:void(0)" class="stretched-link testimonial-trigger" data-bs-toggle="modal"
                                    data-bs-target="#testimonialModal" data-name="{{ $testimonial->title }}"
                                    data-video="{{ $videoId ? 'https://www.youtube.com/embed/' . $videoId : '' }}"
                                    data-image="{{ $testimonial->image ? asset('storage/' . $testimonial->image) : '' }}"
                                    data-description="{{ strip_tags($testimonial->description) }}">
                                    <figure>
                                        @if($testimonial->image)
                                            <img src="{{ asset('storage/' . $testimonial->image) }}"
                                                alt="{{ $testimonial->title }}">
                                        @else
                                            <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="Testimonial">
                                        @endif
                                    </figure>
                                </a>
                            </div>
                            <div class="service-item-body-prime">
                                <div class="service-item-content-prime">
                                    <h3>
                                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#testimonialModal"
                                            data-name="{{ $testimonial->title }}"
                                            data-video="{{ $videoId ? 'https://www.youtube.com/embed/' . $videoId : '' }}"
                                            data-image="{{ $testimonial->image ? asset('storage/' . $testimonial->image) : '' }}"
                                            data-description="{{ strip_tags($testimonial->description) }}"
                                            class="testimonial-trigger">{{ $testimonial->title }}</a>
                                        <p class="text-primary">Verified Client</p>
                                    </h3>
                                </div>
                                <div class="service-readmore-btn-prime">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#testimonialModal"
                                        data-name="{{ $testimonial->title }}"
                                        data-video="{{ $videoId ? 'https://www.youtube.com/embed/' . $videoId : '' }}"
                                        data-image="{{ $testimonial->image ? asset('storage/' . $testimonial->image) : '' }}"
                                        data-description="{{ strip_tags($testimonial->description) }}"
                                        class="readmore-btn testimonial-trigger">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p>No testimonials available.</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-4 justify-content-center d-flex">
                {{ $testimonials->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Use event delegation to handle clicks on dynamically generated elements
            $(document).on('click', '.testimonial-trigger', function () {
                var name = $(this).data('name');
                var videoUrl = $(this).data('video');
                var imageUrl = $(this).data('image');
                var description = $(this).data('description');

                var modal = $('#testimonialModal');

                // Set Text
                modal.find('#modal-author-name').text(name);
                modal.find('#modal-description').html(description);

                // Handle Media logic
                if (videoUrl && videoUrl !== "") {
                    modal.find('#modal-iframe').attr('src', videoUrl + "?autoplay=1");
                    $('#modal-video-wrapper').removeClass('d-none');
                    $('#modal-image-wrapper').addClass('d-none');
                } else {
                    modal.find('#modal-iframe').attr('src', '');
                    modal.find('#modal-img').attr('src', imageUrl);
                    $('#modal-video-wrapper').addClass('d-none');
                    $('#modal-image-wrapper').removeClass('d-none');
                }
            });

            // Clear iframe on close to stop video audio
            $('#testimonialModal').on('hidden.bs.modal', function () {
                $(this).find('#modal-iframe').attr('src', '');
            });
        });
    </script>
@endpush