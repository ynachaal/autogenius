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

                {{-- Row 1: Heading & Description (50/50) --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Section Heading</label>
                        <input type="text" class="form-control"
                            name="meta[heading]"
                            placeholder="e.g. Our Coverage Area"
                            value="{{ old('meta.heading', $meta['service-area_heading']->meta_value ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Section Description</label>
                        <textarea class="form-control" rows="1"
                            name="meta[description]"
                            placeholder="Brief overview of where you operate...">{{ old('meta.description', $meta['service-area_description']->meta_value ?? '') }}</textarea>
                    </div>
                </div>

                <h5 class="fw-medium pb-2 mb-3 border-bottom">Service Locations</h5>

                {{-- Row 2: Locations Grid (50/50) --}}
                <div class="row">
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="col-md-6 mb-3">
                            <label class="form-label small">Location {{ $i }}</label>
                            <input type="text" class="form-control"
                                name="meta[location{{ $i }}]"
                                placeholder="City or Region Name"
                                value="{{ old('meta.location' . $i, $meta['service-area_location' . $i]->meta_value ?? '') }}">
                        </div>
                    @endfor
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                        <i class="fas fa-save me-1"></i> Save Service Area
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function () {
                if (typeof $.fn.validate !== 'undefined') {
                    $("#service-area-form").validate({
                        rules: {
                            "meta[heading]": { required: true, maxlength: 120 },
                            "meta[description]": { required: true, maxlength: 300 }
                        },
                        errorElement: 'span',
                        errorClass: 'text-danger small'
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>