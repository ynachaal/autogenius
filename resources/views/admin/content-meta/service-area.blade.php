<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-medium mb-0 text-dark">
            Service Area Content
        </h2>
    </x-slot>

    <div class="card card-primary card-outline">
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form id="service-area-form" method="POST"
                action="{{ route('admin.content-meta.save', ['section' => 'service-area']) }}">
                @csrf

                {{-- Section Heading --}}
                <div class="mb-3">
                    <label class="form-label">Section Heading</label>
                    <input type="text" class="form-control"
                        name="meta[heading]" {{-- Removed service_area_ prefix --}}
                        value="{{ old('meta.heading', $meta['service-area_heading']->meta_value ?? '') }}">
                </div>

                {{-- Section Description --}}
                <div class="mb-4">
                    <label class="form-label">Section Description</label>
                    <textarea class="form-control" rows="3"
                        name="meta[description]">{{-- Removed service_area_ prefix --}}{{ old(
                            'meta.description',
                            $meta['service-area_description']->meta_value ?? ''
                        ) }}</textarea>
                </div>

                <h5 class="fw-medium pb-3 mb-3 border-bottom">Service Locations</h5>

                @for ($i = 1; $i <= 6; $i++)
                    <div class="mb-3">
                        <label class="form-label">Location {{ $i }}</label>
                        <input type="text" class="form-control"
                            name="meta[location{{ $i }}]" {{-- Removed service_area_ prefix --}}
                            value="{{ old(
                                'meta.location' . $i,
                                $meta['service-area_location' . $i]->meta_value ?? ''
                            ) }}">
                    </div>
                @endfor

                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary">
                        Save Service Area
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
        /*     $(function () {
                if ($.fn.validate) {
                    $("#service-area-form").validate({
                        rules: {
                            "meta[heading]": {
                                required: true,
                                maxlength: 120
                            },
                            "meta[description]": {
                                required: true,
                                maxlength: 300
                            },
                            @for ($i = 1; $i <= 6; $i++)
                            "meta[location{{ $i }}]": {
                                required: false,
                                maxlength: 100
                            },
                            @endfor
                        },
                        errorElement: 'span',
                        errorClass: 'text-danger small'
                    });
                }
            }); */
        </script>
    @endpush
</x-app-layout>