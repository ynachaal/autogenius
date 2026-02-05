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
                    {{-- Section Main Heading --}}
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Section Main Heading</label>
                            <input type="text" class="form-control" name="meta[heading]"
                                value="{{ old('meta.heading', $meta[$section . '_heading']->meta_value ?? '') }}">
                        </div>
                    </div>

                    {{-- Section Image Upload --}}
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Section Illustration/Image</label>
                            @if(isset($meta[$section . '_image']))
                                <div class="mb-2">
                                    @if(isset($meta[$section . '_image']) && !empty($meta[$section . '_image']->meta_value))
                                        <img src="{{ asset('storage/' . $meta[$section . '_image']->meta_value) }}"
                                            class="img-thumbnail" style="height: 50px;" alt="Section Image">
                                    @endif
                                </div>
                            @endif
                            <input type="file" class="form-control" name="meta[image]">
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Comparison / Content Blocks --}}
                <h5 class="fw-medium pb-3 mb-3 border-bottom">Content Blocks / Comparison Points</h5>

                <div class="row mb-2 d-none d-md-flex">
                    <div class="col-md-6"><small class="text-muted fw-bold">LEFT SIDE (e.g. Pain Point)</small></div>
                    <div class="col-md-6"><small class="text-muted fw-bold">RIGHT SIDE (e.g. Solution)</small></div>
                </div>

                @for ($i = 1; $i <= 6; $i++)
                    <div class="card p-3 bg-light mb-3">
                        <div class="row">
                            {{-- Title / Pain Point --}}
                            <div class="col-md-6">
                                <div class="mb-2 mb-md-0">
                                    <label class="form-label small">Point {{ $i }} (Left)</label>
                                    <input type="text" class="form-control" name="meta[pain_point_{{ $i }}]"
                                        value="{{ old('meta.pain_point_' . $i, $meta[$section . '_pain_point_' . $i]->meta_value ?? '') }}">
                                </div>
                            </div>

                            {{-- Description / Solution --}}
                            <div class="col-md-6">
                                <div>
                                    <label class="form-label small">Point {{ $i }} (Right)</label>
                                    <input type="text" class="form-control" name="meta[solution_{{ $i }}]"
                                        value="{{ old('meta.solution_' . $i, $meta[$section . '_solution_' . $i]->meta_value ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor

                {{-- Footer / CTA Area --}}
                <div class="mt-4 p-3 border rounded">
                    <label class="form-label fw-bold">Call to Action (CTA) Text</label>
                    <textarea class="form-control" name="meta[cta_text]" rows="2"
                        placeholder="e.g. Buying a car worth lakhs? Get an expert.">{{ old('meta.cta_text', $meta[$section . '_cta_text']->meta_value ?? '') }}</textarea>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4">
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
                            "meta[heading]": { required: true, maxlength: 150 },
                            @for ($i = 1; $i <= 6; $i++)
                                        "meta[pain_point_{{ $i }}]": { maxlength: 200 },
                                "meta[solution_{{ $i }}]": { maxlength: 200 },
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