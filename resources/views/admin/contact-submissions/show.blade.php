<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Inquiry from: :name', ['name' => $contactSubmission->name]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Message Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.contact-submissions.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back to List
                        </a>
                        <form action="{{ route('admin.contact-submissions.destroy', $contactSubmission) }}" 
                              method="POST" class="d-inline" id="delete-form-{{ $contactSubmission->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return showConfirmationModal('delete-form-{{ $contactSubmission->id }}', 'this message', 'Submission')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Sender:</strong> {{ $contactSubmission->name }}</p>
                            <p class="mb-2"><strong>Email:</strong> 
                                <a href="mailto:{{ $contactSubmission->email }}">{{ $contactSubmission->email }}</a>
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="text-muted mb-2">
                                <strong>Received:</strong> {{ $contactSubmission->created_at->format('M d, Y - h:i A') }}
                            </p>
                            <p>
                                <strong>Status:</strong> 
                                <span class="badge {{ $contactSubmission->is_read ? 'bg-secondary' : 'bg-success' }}">
                                    {{ $contactSubmission->is_read ? 'Read' : 'Unread' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="bg-light p-4 border rounded">
                        <h5 class="fw-bold mb-3">Message Body:</h5>
                        <p class="text-dark" style="white-space: pre-wrap;">{{ $contactSubmission->message }}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="mailto:{{ $contactSubmission->email }}?subject=Re: Contact Inquiry" class="btn btn-primary">
                        <i class="bi bi-reply-fill me-1"></i> Reply via Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>