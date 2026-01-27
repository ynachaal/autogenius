<div class="col-xl-3 col-lg-4 col-md-6">
    <div class="service-item-prime wow fadeInUp" data-wow-delay="{{ $delay }}s">
        <div class="service-item-image-prime">
            <a href="{{ url('services/' . $service->slug) }}">
                <figure>
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}">
                    @else
                        <img src="{{ asset('images/placeholder-car.jpg') }}" alt="Placeholder Image">
                    @endif
                </figure>
            </a>
        </div>
        <div class="service-item-body-prime">
            <div class="service-item-content-prime">
                <h3>
                    <a href="{{ url('services/' . $service->slug) }}">{{ $service->title }}</a>
                </h3>
                <p>{{ $service->sub_heading }}</p>
            </div>
            <div class="service-readmore-btn-prime">
                <a href="{{ url('services/' . $service->slug) }}" class="readmore-btn">Read More</a>
            </div>
        </div>
    </div>
</div>
