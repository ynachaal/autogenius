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

                {{-- Section Heading (ONLY ONE) --}}
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Section Heading</label>
                        <input type="text" class="form-control" name="meta[blocks_heading]"
                            value="{{ old('meta.blocks_heading', $meta[$section . '_blocks_heading']->meta_value ?? '') }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <h5 class="fw-medium pb-3 mb-3 border-bottom">Content Blocks</h5>
                </div>

                @for ($i = 1; $i <= 4; $i++)
                                <div class="col-md-12">
                                    <div class="card p-3 bg-light mb-3">

                                        {{-- Title --}}
                                        <div class="mb-3">
                                            <label class="form-label">Title {{ $i }}</label>
                                            <input type="text" class="form-control" name="meta[counter{{ $i }}_title]"
                                                value="{{ old('meta.counter' . $i . '_title', $meta[$section . '_counter' . $i . '_title']->meta_value ?? '') }}">
                                        </div>


                                        {{-- Description --}}
                                        <div class="mb-3">
                                            <label class="form-label">Description {{ $i }}</label>
                                            <textarea class="form-control" rows="3" name="meta[counter{{ $i }}_description]">{{ old(
                        'meta.counter' . $i . '_description',
                        $meta[$section . '_counter' . $i . '_description']->meta_value ?? ''
                    ) }}</textarea>
                                        </div>

                                    </div>
                                </div>
                @endfor

                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary">
                        Save Section
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
                            "meta[blocks_heading]": {
                                required: true,
                                maxlength: 100
                            },
                            "meta[counter1_description]": {
                                required: true,
                                maxlength: 300
                            },
                            "meta[counter2_description]": {
                                required: true,
                                maxlength: 300
                            },
                            "meta[counter3_description]": {
                                required: true,
                                maxlength: 300
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>