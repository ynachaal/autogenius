@extends('layouts.front')

@section('title', $page->meta_title ?? '')
@section('meta_description', $page->meta_description ?? '')
@section('meta_keywords', $page->meta_keywords ?? '')

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-theme="dark">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <div class="modal-header border-0 p-2 px-3">
                    <h1 class="modal-title h6 fw-normal" id="exampleModalLabel">Rahul Mehta</h1>
                    <button type="button" class="btn-close opacity-100 shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe width="100%" height="500" src="https://www.youtube.com/embed/t8qUT1scBnI?si=ebnLkKANI5r6jjDK" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <div class="p-3 bg-white text-black">
                        <p class="small m-0 fw-normal">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa cum itaque nisi provident unde? At autem consequuntur culpa, deserunt magni nam non! Consectetur culpa et ipsam necessitatibus, provident quod sit!</p>
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
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="service-item-prime wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item-image-prime">
                            <a href="javascript:void(0)" class="stretched-link" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <figure>
                                    <img src="https://autogenius.wlslab.com/storage/services/YUEbadQDylRc8KZqTKC1i2R44LZi7zWnANm80AlF.jpg" alt="New Car Consultation">
                                </figure>
                            </a>
                        </div>
                        <div class="service-item-body-prime">
                            <div class="service-item-content-prime">
                                <h3>
                                    <a href="javascript:void(0)" class="stretched-link" data-bs-toggle="modal" data-bs-target="#exampleModal">Rahul Mehta</a>
                                    <p class="text-primary">Business Consultant</p>
                                </h3>
                            </div>
                            <div class="service-readmore-btn-prime">
                                <a href="javascript:void(0)" class="readmore-btn">View</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="service-item-prime wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item-image-prime">
                            <a href="javascript:void(0)" class="stretched-link" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <figure>
                                    <img src="https://autogenius.wlslab.com/storage/services/YUEbadQDylRc8KZqTKC1i2R44LZi7zWnANm80AlF.jpg" alt="New Car Consultation">
                                </figure>
                            </a>
                        </div>
                        <div class="service-item-body-prime">
                            <div class="service-item-content-prime">
                                <h3>
                                    <a href="javascript:void(0)" class="stretched-link" data-bs-toggle="modal" data-bs-target="#exampleModal">Rahul Mehta</a>
                                    <p class="text-primary">Business Consultant</p>
                                </h3>
                            </div>
                            <div class="service-readmore-btn-prime">
                                <a href="javascript:void(0)" class="readmore-btn">View</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="service-item-prime wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item-image-prime">
                            <a href="javascript:void(0)" class="stretched-link" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <figure>
                                    <img src="https://autogenius.wlslab.com/storage/services/YUEbadQDylRc8KZqTKC1i2R44LZi7zWnANm80AlF.jpg" alt="New Car Consultation">
                                </figure>
                            </a>
                        </div>
                        <div class="service-item-body-prime">
                            <div class="service-item-content-prime">
                                <h3>
                                    <a href="javascript:void(0)" class="stretched-link" data-bs-toggle="modal" data-bs-target="#exampleModal">Rahul Mehta</a>
                                    <p class="text-primary">Business Consultant</p>
                                </h3>
                            </div>
                            <div class="service-readmore-btn-prime">
                                <a href="javascript:void(0)" class="readmore-btn">View</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="service-item-prime wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item-image-prime">
                            <a href="javascript:void(0)" class="stretched-link" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <figure>
                                    <img src="https://autogenius.wlslab.com/storage/services/YUEbadQDylRc8KZqTKC1i2R44LZi7zWnANm80AlF.jpg" alt="New Car Consultation">
                                </figure>
                            </a>
                        </div>
                        <div class="service-item-body-prime">
                            <div class="service-item-content-prime">
                                <h3>
                                    <a href="javascript:void(0)" class="stretched-link" data-bs-toggle="modal" data-bs-target="#exampleModal">Rahul Mehta</a>
                                    <p class="text-primary">Business Consultant</p>
                                </h3>
                            </div>
                            <div class="service-readmore-btn-prime">
                                <a href="javascript:void(0)" class="readmore-btn">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
