<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">Inspection: {{ $inspection->vehicle_name }}</h2>
    </x-slot>

    <div class="content py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Request Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Customer Name:</div>
                                <div class="col-sm-8">{{ $inspection->customer_name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Mobile / Email:</div>
                                <div class="col-sm-8">{{ $inspection->customer_mobile }} / {{ $inspection->customer_email ?? 'N/A' }}</div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Inspection Date:</div>
                                <div class="col-sm-8">{{ \Carbon\Carbon::parse($inspection->inspection_date)->format('l, d F Y') }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Location:</div>
                                <div class="col-sm-8 text-primary"><i class="bi bi-geo-alt"></i> {{ $inspection->inspection_location }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h3 class="card-title">Payment History</h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse($inspection->payments as $payment)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <span>₹{{ number_format($payment->amount / 100, 2) }}</span>
                                            <span class="badge {{ $payment->status == 'paid' ? 'bg-success' : 'bg-danger' }}">
                                                {{ strtoupper($payment->status) }}
                                            </span>
                                        </div>
                                        <small class="text-muted d-block">{{ $payment->created_at->format('d M, h:i A') }}</small>
                                        <small class="text-xs text-uppercase">{{ $payment->payment_id }}</small>
                                    </li>
                                @empty
                                    <li class="list-group-item text-center text-muted py-4">No payment attempts found.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>