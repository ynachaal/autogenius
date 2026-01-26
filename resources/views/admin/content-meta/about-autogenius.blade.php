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
                    {{-- Founding Belief / Main Heading --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Main Heading / Belief</label>
                        <textarea class="form-control" name="meta[heading]" rows="2" placeholder="Enter main belief text...">{{ 
                            old('meta.heading', isset($meta[$section . '_heading']) ? $meta[$section . '_heading']->meta_value : '') 
                        }}</textarea>
                    </div>

                    {{-- Intro Text --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Intro Paragraph</label>
                        <textarea class="form-control" name="meta[description1]" rows="2" placeholder="Enter intro text...">{{ 
                            old('meta.description1', isset($meta[$section . '_description1']) ? $meta[$section . '_description1']->meta_value : '') 
                        }}</textarea>
                    </div>
                </div>

                <hr class="my-4">

                {{-- The "Why We Exist" Bullet Points --}}
                <h5 class="fw-medium pb-2 mb-3 border-bottom">Market Issues We Solve (Bullets)</h5>
                <div class="row">
                    @for ($i = 1; $i <= 4; $i++)
                        @php $key = $section . '_market_issue_' . $i; @endphp
                        <div class="col-md-6 mb-3">
                            <label class="form-label small">Issue {{ $i }}</label>
                            <input type="text" class="form-control" name="meta[market_issue_{{ $i }}]"
                                placeholder="e.g. Hidden vehicle issues"
                                value="{{ old('meta.market_issue_'.$i, isset($meta[$key]) ? $meta[$key]->meta_value : '') }}">
                        </div>
                    @endfor
                </div>

                <hr class="my-4">

                {{-- The Mission Statement / Footer Text --}}
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Mission Statement (Standing on Buyer's Side)</label>
                        <input type="text" class="form-control" name="meta[mission_text]" 
                            placeholder="Enter mission statement..."
                            value="{{ old('meta.mission_text', isset($meta[$section . '_mission_text']) ? $meta[$section . '_mission_text']->meta_value : '') }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Closing Hook</label>
                        <input type="text" class="form-control" name="meta[closing_hook]" 
                            placeholder="Enter closing hook..."
                            value="{{ old('meta.closing_hook', isset($meta[$section . '_closing_hook']) ? $meta[$section . '_closing_hook']->meta_value : '') }}">
                    </div>
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
                            "meta[heading]": { required: true },
                            "meta[mission_text]": { required: true }
                        },
                        errorElement: 'span',
                        errorClass: 'text-danger small'
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>