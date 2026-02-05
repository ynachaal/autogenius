@foreach($brands as $brand)
    <div class="swiper-slide">
        <div class="company-logo">
            @if(!empty($brand->image))
                {{-- Updated to use the storage/ path --}}
                <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}">
            @else
                <img src="{{ asset('images/placeholder-car.jpg') }}" alt="Placeholder Image">
            @endif
        </div>
    </div>
@endforeach