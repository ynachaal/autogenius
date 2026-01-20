<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-medium mb-0 text-dark">
            {{ __('Email Template: :title', ['title' => $emailTemplate->title]) }}
        </h2>
    </x-slot>

    <div class="content">
        <div>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Email Template: :title', ['title' => $emailTemplate->title]) }}</h3>
                    <div class="card-tools d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.email-templates.edit', $emailTemplate) }}" class="btn btn-sm btn-primary d-none">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                        </a>
                        {{-- <form action="{{ route('admin.email-templates.destroy', $emailTemplate) }}" method="POST" id="delete-form-{{ $emailTemplate->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return showConfirmationModal('delete-form-{{ $emailTemplate->id }}', '{{ Str::limit($emailTemplate->title, 60) }}', 'Email Template')">
                                <i class="fa-solid fa-trash-can me-1"></i> Delete
                            </button>
                        </form> --}}
                        <a href="{{ route('admin.email-templates.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-2">
                        <strong>Subject:</strong> {{$emailTemplate->subject}}
                    </p>
                    <p class="text-muted mb-2">
                        <strong>Status:</strong>
                        <span class="badge {{ $emailTemplate->is_published ? 'bg-success' : 'bg-warning' }}">
                            {{ $emailTemplate->is_published ? 'Published' : 'Unpublished' }}
                        </span>
                    </p>
                    <p class="text-muted mb-2"><strong>Created at:</strong> {{ $emailTemplate->created_at->format('M d, Y') }}</p>
                    <hr class="my-3">
                    <div>
                        <strong>Content:</strong>
                        <div class="text-muted ql-editor">{!! $emailTemplate->content ?? '-' !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
