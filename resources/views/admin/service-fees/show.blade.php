<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Service Fee: :segment', ['segment' => $serviceFee->car_segment]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Fee Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.service-fees.edit', $serviceFee) }}"
                           class="btn btn-sm btn-primary"
                           data-toggle="tooltip"
                           title="Edit Fee">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>

                        <form action="{{ route('admin.service-fees.destroy', $serviceFee) }}"
                              method="POST"
                              class="d-inline"
                              id="delete-form-{{ $serviceFee->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    data-toggle="tooltip"
                                    title="Delete Fee"
                                    onclick="return confirm('Are you sure you want to delete this fee segment?')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>

                        <a href="{{ route('admin.service-fees.index') }}"
                           class="btn btn-sm btn-secondary"
                           data-toggle="tooltip"
                           title="Back to List">
                            <i class="bi bi-list me-1"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-2">
                                <strong>Car Segment:</strong> <span class="fw-semibold text-dark">{{ $serviceFee->car_segment }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Status:</strong> 
                                <span class="badge {{ $serviceFee->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $serviceFee->status ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="text-muted mb-2">
                                <strong>Created at:</strong> {{ $serviceFee->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box bg-light shadow-sm">
                                <div class="p-3">
                                    <span class="d-block text-muted">Full Report Fee</span>
                                    <h4 class="fw-bold mb-0">₹{{ number_format($serviceFee->full_report_fee, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-light shadow-sm">
                                <div class="p-3">
                                    <span class="d-block text-muted">Booking Amount</span>
                                    <h4 class="fw-bold mb-0">₹{{ number_format($serviceFee->booking_amount, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>