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
                            <div class="card-tools">
                                <a href="{{ route('admin.car-inspections.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="bi bi-list"></i> Back to List
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Service Type:</div>
                                <div class="col-sm-8">
                                    <span
                                        class="badge bg-info text-dark">{{ $inspection->service_type ?? 'Standard Inspection' }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Customer Name:</div>
                                <div class="col-sm-8">{{ $inspection->customer_name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Mobile / Email:</div>
                                <div class="col-sm-8">{{ $inspection->customer_mobile }} /
                                    {{ $inspection->customer_email ?? 'N/A' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Inspection Date:</div>
                                <div class="col-sm-8">
                                    <span class="text-dark fw-bold">
                                        <i class="bi bi-calendar-event"></i>
                                        {{ \Carbon\Carbon::parse($inspection->inspection_date)->format('l, d F Y') }}
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 fw-bold">Location:</div>
                                <div class="col-sm-8 text-primary"><i class="bi bi-geo-alt"></i>
                                    {{ $inspection->inspection_location }}</div>
                            </div>

                            {{-- ADDED PAYMENT & SYSTEM INFO SECTION --}}
                            @php
                                $latestPayment = $inspection->payments->sortByDesc('created_at')->first();
                            @endphp

                            <div class="row mt-4">
                                <div class="col-12">
                                    <hr>
                                    <h5 class="fw-bold text-primary mb-3">Payment & System Information</h5>
                                </div>

                                <div class="col-md-4">
                                    <p>
                                        <strong>Payment Status:</strong>
                                        @if($latestPayment)
                                                                            <span
                                                                                class="badge 
                                                                                    {{ $latestPayment->status === 'paid' ? 'bg-success' :
                                            ($latestPayment->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                                                                {{ strtoupper($latestPayment->status) }}
                                                                            </span>
                                        @else
                                            <span class="badge bg-secondary">UNPAID</span>
                                        @endif
                                    </p>

                                    <p><strong>Amount:</strong>
                                        {{ $latestPayment ? '₹' . number_format($latestPayment->amount / 100, 2) : '0.00' }}
                                    </p>

                                    <p><strong>Paid At:</strong>
                                        {{ $latestPayment && $latestPayment->paid_at
    ? $latestPayment->paid_at->format('d M Y, h:i A')
    : 'N/A' }}
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Razorpay Order ID:</strong>
                                        <code class="small">{{ $latestPayment->order_id ?? 'N/A' }}</code>
                                    </p>

                                    <p><strong>Razorpay Payment ID:</strong>
                                        <code class="small">{{ $latestPayment->payment_id ?? 'N/A' }}</code>
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Request Created:</strong>
                                        {{ $inspection->created_at->format('d M Y, h:i A') }}
                                    </p>

                                    @if($latestPayment && $latestPayment->status !== 'paid')
                                        <form
                                            action="{{ route('admin.car-inspections.verify-payment', [$inspection->id, $latestPayment->id]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-patch-check"></i> Verify Payment
                                            </button>
                                        </form>
                                    @endif
                                </div>
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
                                @forelse($inspection->payments->sortByDesc('created_at') as $payment)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <span>₹{{ number_format($payment->amount / 100, 2) }}</span>
                                            <span
                                                class="badge {{ $payment->status == 'paid' ? 'bg-success' : 'bg-danger' }}">
                                                {{ strtoupper($payment->status) }}
                                            </span>
                                        </div>
                                        <small
                                            class="text-muted d-block">{{ $payment->created_at->format('d M, h:i A') }}</small>
                                        <small class="text-xs text-uppercase text-muted">ID:
                                            {{ $payment->payment_id ?? 'N/A' }}</small>
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