<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Slide Detail: :id', ['id' => $slider->id]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Slider Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>

                        <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline" id="delete-form-{{ $slider->id }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete this slider?')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>

                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-list me-1"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        {{-- Media Preview Column --}}
                        <div class="col-md-5 mb-4">
                            <label class="d-block fw-bold text-muted mb-2">Media Preview</label>
                            @if($slider->type == 'image')
                                <img src="{{ asset('storage/' . $slider->file) }}" class="img-fluid rounded border shadow-sm w-100" alt="Slider Image" style="max-height: 300px; object-fit: cover;">
                            @else
                                <video width="100%" height="auto" controls class="rounded border shadow-sm" style="max-height: 300px;">
                                    <source src="{{ asset('storage/' . $slider->file) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                            
                            <div class="mt-3">
                                <span class="badge bg-info text-capitalize">{{ $slider->type }}</span>
                                <span class="badge bg-{{ $slider->status ? 'success' : 'danger' }}">
                                    {{ $slider->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        {{-- Details Column --}}
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <small class="text-uppercase text-muted fw-bold d-block">Category</small>
                                    <span class="fs-6">{{ $slider->category->name ?? 'N/A' }}</span>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <small class="text-uppercase text-muted fw-bold d-block">Created At</small>
                                    <span>{{ $slider->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <small class="text-uppercase text-muted fw-bold d-block">Heading</small>
                                    <h4 class="fw-bold">{{ $slider->heading ?: 'N/A' }}</h4>
                                </div>

                                <div class="col-12 mb-3">
                                    <small class="text-uppercase text-muted fw-bold d-block">Sub Heading</small>
                                    <p class="text-muted fs-5">{{ $slider->subheading ?: 'N/A' }}</p>
                                </div>
                            </div>

                            <hr class="my-3">

                            <div class="row">
                                {{-- Button 1 --}}
                                <div class="col-md-6 mb-3">
                                    <label class="small fw-bold text-muted">Button 1</label>
                                    @if($slider->button1_text)
                                        <div class="mt-1">
                                            <a href="{{ $slider->button1_link }}" target="_blank" class="btn btn-outline-dark btn-sm">
                                                {{ $slider->button1_text }} <i class="bi bi-box-arrow-up-right ms-1 small"></i>
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-muted small">Not configured</p>
                                    @endif
                                </div>

                                {{-- Button 2 --}}
                                <div class="col-md-6 mb-3">
                                    <label class="small fw-bold text-muted">Button 2</label>
                                    @if($slider->button2_text)
                                        <div class="mt-1">
                                            <a href="{{ $slider->button2_link }}" target="_blank" class="btn btn-outline-dark btn-sm">
                                                {{ $slider->button2_text }} <i class="bi bi-box-arrow-up-right ms-1 small"></i>
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-muted small">Not configured</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($slider->deleted_at)
                        <div class="alert alert-warning mt-3 mb-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            This record was soft-deleted on <strong>{{ $slider->deleted_at->format('M d, Y H:i') }}</strong>.
                        </div>
                    @endif
                </div>
                
                <div class="card-footer text-muted small">
                    <strong>Last System Update:</strong> {{ $slider->updated_at->format('M d, Y H:i') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>