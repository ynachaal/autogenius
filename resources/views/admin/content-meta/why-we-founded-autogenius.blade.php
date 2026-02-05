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

                <div class="row mb-4">
                    {{-- Image 1 --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Primary Illustration (Left/Top)</label>
                        @if(isset($meta[$section . '_image1']) && !empty($meta[$section . '_image1']->meta_value))
                            <div class="mb-2">
                                {{-- Updated path --}}
                                <img src="{{ asset('storage/' . $meta[$section . '_image1']->meta_value) }}"
                                    class="img-thumbnail" style="height: 100px;" alt="Primary Illustration">
                            </div>
                        @endif
                        <input type="file" class="form-control" name="meta[image1]">
                    </div>

                    {{-- Image 2 --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Secondary Image (Right/Bottom)</label>
                        @if(isset($meta[$section . '_image2']) && !empty($meta[$section . '_image2']->meta_value))
                            <div class="mb-2">
                                {{-- Updated path --}}
                                <img src="{{ asset('storage/' . $meta[$section . '_image2']->meta_value) }}"
                                    class="img-thumbnail" style="height: 100px;" alt="Secondary Image">
                            </div>
                        @endif
                        <input type="file" class="form-control" name="meta[image2]">
                    </div>
                </div>

                <div class="row">
                    {{-- Main Quote/Heading --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Main Quote (Problem Statement)</label>
                        <textarea class="form-control" name="meta[main_quote]" rows="2"
                            placeholder="e.g. Most car problems don’t start on the road...">{{ 
                            old('meta.main_quote', isset($meta[$section . '_main_quote']) ? $meta[$section . '_main_quote']->meta_value : '') 
                        }}</textarea>
                    </div>

                    {{-- Intro Text --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Mission Intro</label>
                        <input type="text" class="form-control" name="meta[mission_intro]"
                            placeholder="e.g. AutoGenius was created to:"
                            value="{{ old('meta.mission_intro', isset($meta[$section . '_mission_intro']) ? $meta[$section . '_mission_intro']->meta_value : '') }}">
                    </div>
                </div>

                <hr class="my-4">

                {{-- Purpose List Bullets --}}
                <h5 class="fw-medium pb-2 mb-3 border-bottom">Core Purposes (List)</h5>
                <div class="row">
                    @for ($i = 1; $i <= 4; $i++)
                        @php $key = $section . '_purpose_' . $i; @endphp
                        <div class="col-md-6 mb-3">
                            <label class="form-label small">Purpose {{ $i }}</label>
                            <input type="text" class="form-control" name="meta[purpose_{{ $i }}]"
                                placeholder="e.g. Save buyers from bad car decisions"
                                value="{{ old('meta.purpose_' . $i, isset($meta[$key]) ? $meta[$key]->meta_value : '') }}">
                        </div>
                    @endfor
                </div>

                <hr class="my-4">

                {{-- Closing Statement --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Closing Statement</label>
                    <input type="text" class="form-control" name="meta[closing_text]"
                        placeholder="e.g. A car should add comfort to your life - not stress."
                        value="{{ old('meta.closing_text', isset($meta[$section . '_closing_text']) ? $meta[$section . '_closing_text']->meta_value : '') }}">
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                        <i class="fas fa-save me-1"></i> Save {{ ucfirst(str_replace('-', ' ', $section)) }}
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
                            "meta[main_quote]": { required: true }
                        },
                        errorElement: 'span',
                        errorClass: 'text-danger small'
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>