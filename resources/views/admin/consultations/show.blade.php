<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Consultation from: :name', ['name' => $consultation->name]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Booking Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.consultations.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back to List
                        </a>
                        
                        {{-- Status Update Form --}}
                        <form action="{{ route('admin.consultations.updateStatus', $consultation) }}" method="POST" class="d-flex gap-1">
                            @csrf
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="pending" {{ $consultation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $consultation->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $consultation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>

                        <form action="{{ route('admin.consultations.destroy', $consultation) }}" 
                              method="POST" class="d-inline" id="delete-form-{{ $consultation->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return showConfirmationModal('delete-form-{{ $consultation->id }}', 'this booking', 'Consultation')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Client:</strong> {{ $consultation->name }}</p>
                            <p class="mb-2"><strong>Email:</strong> 
                                <a href="mailto:{{ $consultation->email }}">{{ $consultation->email }}</a>
                            </p>
                            <p class="mb-2"><strong>Phone:</strong> 
                                {{ $consultation->phone ?? 'N/A' }}
                            </p>
                            <p class="mb-2 text-primary"><strong>Preferred Date:</strong> 
                                {{ \Carbon\Carbon::parse($consultation->preferred_date)->format('F d, Y') }}
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="text-muted mb-2">
                                <strong>Request Received:</strong> {{ $consultation->created_at->format('M d, Y - h:i A') }}
                            </p>
                            <p>
                                <strong>Current Status:</strong> 
                                <span class="badge {{ $consultation->status == 'pending' ? 'bg-warning text-dark' : ($consultation->status == 'completed' ? 'bg-success' : 'bg-danger') }}">
                                    {{ ucfirst($consultation->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="mb-4">
                        <h5 class="fw-bold">Subject:</h5>
                        <p class="lead">{{ $consultation->subject }}</p>
                    </div>

                    <div class="bg-light p-4 border rounded">
                        <h5 class="fw-bold mb-3">Message / Requirements:</h5>
                        <p class="text-dark" style="white-space: pre-wrap;">{{ $consultation->message ?? 'No additional details provided.' }}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="mailto:{{ $consultation->email }}?subject=Re: Consultation - {{ $consultation->subject }}" class="btn btn-primary">
                        <i class="bi bi-reply-fill me-1"></i> Contact Client
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>