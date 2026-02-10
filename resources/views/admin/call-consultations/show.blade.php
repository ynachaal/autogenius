<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">Consultation: {{ $consultation->customer_name }}</h2>
    </x-slot>

    <div class="content py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Consultation Details</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.call-consultations.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="bi bi-list"></i> Back to List
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Service Choice:</div>
                                <div class="col-sm-8">
                                    <span class="badge bg-info text-dark">{{ $consultation->selected_service }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Customer Name:</div>
                                <div class="col-sm-8">{{ $consultation->customer_name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Contact Info:</div>
                                <div class="col-sm-8">{{ $consultation->customer_mobile }} / {{ $consultation->customer_email }}</div>
                            </div>
                            <hr>
                            
                            @php $latestPayment = $consultation->payments->sortByDesc('created_at')->first(); @endphp

                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="fw-bold text-primary mb-3">Payment & System Information</h5>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Payment Status:</strong>
                                        @if($latestPayment)
                                            <span class="badge {{ $latestPayment->status === 'paid' ? 'bg-success' : 'bg-warning' }}">
                                                {{ strtoupper($latestPayment->status) }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">UNPAID</span>
                                        @endif
                                    </p>
                                    <p><strong>Amount:</strong> ₹{{ $latestPayment ? number_format($latestPayment->amount / 100, 2) : '0.00' }}</p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Order ID:</strong> <code class="small">{{ $latestPayment->order_id ?? 'N/A' }}</code></p>
                                    <p><strong>Payment ID:</strong> <code class="small">{{ $latestPayment->payment_id ?? 'N/A' }}</code></p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Booked On:</strong> {{ $consultation->created_at->format('d M Y, h:i A') }}</p>
                                    @if($latestPayment && $latestPayment->status !== 'paid')
                                        <form action="{{ route('admin.call-consultations.verify-payment', [$consultation->id, $latestPayment->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-patch-check"></i> Verify Now
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>