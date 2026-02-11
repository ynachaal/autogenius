<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Page: :title', ['title' => $page->title]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Page Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-2">
                                <strong>Slug:</strong> <span class="fw-semibold">{{ $page->slug ?? '-' }}</span>
                            </p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="mb-4">
                        <strong class="d-block mb-2 text-primary">Main Content:</strong>
                        <div class="page-content p-3 border rounded bg-light">
                            {!! $page->content ?? '<span class="text-muted">No content provided.</span>' !!}
                        </div>
                    </div>

                    {{-- === ADD SUB CONTENT SECTION HERE === --}}
                    @if(!empty($page->sub_content) && strip_tags($page->sub_content) !== '')
                        <div class="mb-4">
                            <strong class="d-block mb-2 text-primary">Sub Content:</strong>
                            <div class="page-sub-content p-3 border rounded bg-light">
                                {!! $page->sub_content !!}
                            </div>
                        </div>
                    @endif 
                    {{-- ==================================== --}}

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-12">
                            <h5 class="fw-bold">SEO Meta Information</h5>
                            <p><strong>Meta Title:</strong> {{ $page->meta_title ?? '-' }}</p>
                            <p><strong>Meta Description:</strong> {{ $page->meta_description ?? '-' }}</p>
                            <p><strong>Meta Keywords:</strong> {{ $page->meta_keywords ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>