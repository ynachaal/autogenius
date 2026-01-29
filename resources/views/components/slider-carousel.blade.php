@if($sliders->count())
<div class="col-xl-6">
    <div class="approach-image-box wow fadeInUp" data-wow-delay="0.2s">
        <div class="approach-image-box-1 w-100">
            <div id="{{ $carouselId }}" class="carousel slide carousel-fade">
                <div class="carousel-inner">

                    @foreach($sliders as $index => $slider)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="approach-img">
                                <figure class="image-anime">
                                    <img src="{{ Storage::url($slider->file) }}"
                                         alt="{{ $slider->heading ?? 'Slider Image' }}">
                                </figure>
                            </div>
                        </div>
                    @endforeach

                </div>

                @if($sliders->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}"
                            data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}"
                            data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
