<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-medium mb-0 text-dark">
            {{ ucfirst($section ?? 'Section') }} Content
        </h2>
    </x-slot>

    <div class="card card-primary card-outline">
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form id="content-meta-form" method="POST"
                action="{{ route('admin.content-meta.save', ['section' => $section ?? 'default']) }}"
                enctype="multipart/form-data">
                @csrf

                {{-- Section Heading --}}
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold">Section Heading</label>
                        <input type="text" class="form-control" name="meta[blocks_heading]"
                            placeholder="Enter main heading..."
                            value="{{ old('meta.blocks_heading', $meta[$section . '_blocks_heading']->meta_value ?? '') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h5 class="fw-medium pb-2 mb-3 border-bottom">Content Blocks</h5>
                    </div>
                </div>

                {{-- Blocks Grid (50/50) --}}
                <div class="row">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="col-md-6 mb-4">
                            <div class="card p-3 bg-light border-0 shadow-sm h-100">
                                <h6 class="fw-bold text-primary mb-3">Feature Block {{ $i }}</h6>

                                {{-- Image Upload --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Image {{ $i }}</label>
                                    <input type="file" class="form-control" name="meta[counter{{ $i }}_image]" accept="image/*">

                                    @if(isset($meta[$section . '_counter' . $i . '_image']))
                                        <div class="mt-2">
                                            <img src="{{ asset($meta[$section . '_counter' . $i . '_image']->meta_value) }}"
                                                class="img-thumbnail" style="max-height:80px">
                                        </div>
                                    @endif
                                </div>

                                {{-- Description --}}
                                <div class="mb-0">
                                    <label class="form-label small fw-bold">Description {{ $i }}</label>
                                    <textarea class="form-control" rows="3" name="meta[counter{{ $i }}_description]"
                                        placeholder="Describe this feature...">{{ old(
                                        'meta.counter' . $i . '_description',
                                        $meta[$section . '_counter' . $i . '_description']->meta_value ?? ''
                                    ) }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="mt-2 text-end">
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                        <i class="fas fa-save me-1"></i> Save {{ ucfirst($section) }}
                    </button>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                if (typeof $.fn.validate !== 'undefined') {
                    $("#content-meta-form").validate({
                        rules: {
                            "meta[blocks_heading]": { required: true, maxlength: 100 },
                            @for ($i = 1; $i <= 3; $i++)
                            "meta[counter{{ $i }}_description]": { required: true, maxlength: 300 },
                            @endfor
                        },
                        errorElement: 'span',
                        errorClass: 'text-danger small'
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>