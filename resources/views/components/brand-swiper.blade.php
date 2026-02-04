@foreach($brands as $brand)
    <div class="swiper-slide">
        <div class="company-logo">
          @if(isset($brand->image))
                <img src="{{ asset('/' . $brand->image) }}" alt="{{ $brand->name }}">
            @else
                <img src="{{ asset('images/placeholder-car.jpg') }}" alt="Placeholder Image">
            @endif
        </div>
    </div>
@endforeach