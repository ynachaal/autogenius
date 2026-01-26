<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-medium mb-0 text-dark">
            {{ ucfirst(str_replace('-', ' ', $section ?? 'Section')) }} Content
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

                <div class="row">
                    {{-- Main Section Heading --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Section Heading</label>
                        <input type="text" class="form-control" name="meta[heading]"
                            value="{{ old('meta.heading', $meta[$section . '_heading']->meta_value ?? '') }}"
                            placeholder="e.g. Protecting Buyers Every Step of the Way">
                    </div>

                    {{-- Description 1 --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Description 1 (Primary)</label>
                        <textarea class="form-control" name="meta[description1]" rows="4" 
                            placeholder="Enter the first paragraph or primary description...">{{ 
                            old('meta.description1', $meta[$section . '_description1']->meta_value ?? '') 
                        }}</textarea>
                    </div>

                    {{-- Description 2 --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Description 2 (Secondary/Supporting)</label>
                        <textarea class="form-control" name="meta[description2]" rows="4" 
                            placeholder="Enter the second paragraph or supporting text...">{{ 
                            old('meta.description2', $meta[$section . '_description2']->meta_value ?? '') 
                        }}</textarea>
                    </div>

                    {{-- Image Upload --}}
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-bold">Section Image</label>
                        <div class="d-flex align-items-start gap-3">
                            @if(isset($meta[$section . '_image']))
                                <div class="position-relative">
                                    <img src="{{ asset('/' . $meta[$section . '_image']->meta_value) }}" 
                                         class="img-thumbnail" style="max-height: 150px; width: auto;">
                                    <div class="small text-muted mt-1 text-center">Current Image</div>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <input type="file" class="form-control" name="meta[image]">
                                <small class="text-muted d-block mt-1">
                                    Recommended size: 800x600px. Supports JPG, PNG, WebP.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                        <i class="fas fa-shield-alt me-1"></i> Save {{ ucfirst(str_replace('-', ' ', $section)) }}
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
                            "meta[heading]": { required: true, maxlength: 200 },
                            "meta[description1]": { required: true },
                            "meta[description2]": { required: false }
                        },
                        errorElement: 'span',
                        errorClass: 'text-danger small'
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>