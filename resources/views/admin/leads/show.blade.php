<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Lead Details: :name', ['name' => $lead->full_name]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Full Requirement Profile</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.leads.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-list me-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        {{-- LEFT COLUMN --}}
                        <div class="col-md-6">
                            {{-- Customer Information --}}
                            <h5 class="fw-bold text-primary mb-3">Customer Information</h5>
                            <p><strong>Full Name:</strong> {{ $lead->full_name }}</p>
                            <p><strong>Mobile:</strong> {{ $lead->mobile ?? 'N/A' }}</p>
                            <p><strong>City:</strong> {{ $lead->city ?? 'N/A' }}</p>
                            <p><strong>Service:</strong> {{ $lead->service_required ?? 'N/A' }}</p>
                            <p><strong>Preferred Contact:</strong> {{ $lead->preferred_contact_method ?? 'N/A' }}</p>

                            <hr>

                            {{-- Budget & Ownership Plan --}}
                            <h5 class="fw-bold text-primary mb-3">Budget & Ownership Plan</h5>
                            <p><strong>Budget:</strong> {{ $lead->budget ? '₹' . number_format($lead->budget) : 'N/A' }}</p>
                            <p><strong>Max Stretch Budget:</strong>
                                {{ ($lead->max_budget && $lead->max_budget > 0) ? '₹' . number_format($lead->max_budget) : 'N/A' }}
                            </p>
                            <p><strong>Expected Ownership Period:</strong> {{ $lead->ownership_period ?? 'N/A' }}</p>

                            <hr>

                            {{-- How Will You Use the Car? --}}
                            <h5 class="fw-bold text-primary mb-3">How Will You Use the Car?</h5>
                            <p><strong>Primary Usage:</strong> {{ $lead->primary_usage ?? 'N/A' }}</p>
                            <p><strong>Running Pattern:</strong> {{ $lead->running_pattern ?? 'N/A' }}</p>
                            <p><strong>Approx KM:</strong> {{ $lead->approx_running ?? '0' }}</p>
                            <p><strong>No. of Passengers Usually:</strong> {{ $lead->passengers ?? 'N/A' }}</p>
                        </div>

                        {{-- RIGHT COLUMN --}}
                        <div class="col-md-6">
                            {{-- Your Preferences --}}
                            <h5 class="fw-bold text-primary mb-3">Your Preferences</h5>
                            <p><strong>Preferred Body Type:</strong>
                                {{ !empty($lead->body_type) ? implode(', ', (array) $lead->body_type) : 'N/A' }}</p>
                            <p><strong>Fuel Preference:</strong>
                                {{ !empty($lead->fuel_preference) ? implode(', ', (array) $lead->fuel_preference) : 'N/A' }}
                            </p>
                            <p><strong>Gearbox Preference:</strong> {{ $lead->gearbox ?? 'N/A' }}</p>
                            <p><strong>Ride Comfort Priority:</strong> {{ $lead->ride_comfort ?? 'N/A' }}</p>

                            <div class="mb-3">
                                <strong>Feature Priority:</strong>
                                @php $features = (array) $lead->feature_priority; @endphp
                                @forelse($features as $feature)
                                    <span class="badge bg-dark me-1">{{ $feature }}</span>
                                @empty
                                    <span class="text-muted">N/A</span>
                                @endforelse
                            </div>

                            <p><strong>Noise Sensitivity:</strong> {{ $lead->noise_sensitivity ?? 'N/A' }}</p>
                            <p><strong>Colour Preference:</strong> {{ $lead->color_preference ?? 'N/A' }}</p>
                            <p><strong>Max Owners:</strong> {{ $lead->max_owners ?? 'N/A' }}</p>
                            <p><strong>Accident History:</strong> {{ $lead->accident_history ?? 'N/A' }}</p>
                            <p><strong>Purchase Timeline:</strong> {{ $lead->purchase_timeline ?? 'N/A' }}</p>
                            <p><strong>Insurance Preference:</strong> {{ $lead->insurance_preference ?? 'N/A' }}</p>

                            <hr>

                            {{-- Final Details --}}
                            <h5 class="fw-bold text-primary mb-3">Final Details</h5>
                            <p><strong>Decision Maker:</strong> {{ $lead->decision_maker ?? 'N/A' }}</p>
                            <p><strong>Existing Car Owned:</strong> {{ $lead->existing_car ?: 'N/A' }}</p>

                            <div class="mt-3 p-3 bg-light rounded border">
                                <strong>Reason for Upgrade / Change:</strong><br>
                                <p class="text-muted mb-0">{{ $lead->upgrade_reason ?: 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- NEW ROW: PAYMENT & SYSTEM INFO --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <hr>
                            <h5 class="fw-bold text-primary mb-3">Payment & System Information</h5>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Payment Status:</strong> 
                                <span class="badge {{ $lead->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }}">
                                    {{ strtoupper($lead->payment_status) }}
                                </span>
                            </p>
                            <p><strong>Amount Paid:</strong> {{ $lead->amount_paid ? '₹' . ($lead->amount_paid / 100) : '0.00' }}</p>
                            <p><strong>Paid At:</strong> {{ $lead->paid_at ? \Carbon\Carbon::parse($lead->paid_at)->format('d M Y, h:i A') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Razorpay Order ID:</strong> <code class="small">{{ $lead->razorpay_order_id ?? 'N/A' }}</code></p>
                            <p><strong>Razorpay Payment ID:</strong> <code class="small">{{ $lead->razorpay_payment_id ?? 'N/A' }}</code></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Declaration Accepted:</strong> 
                                {!! $lead->declaration 
                                    ? '<span class="text-success fw-bold">YES</span>' 
                                    : '<span class="text-danger fw-bold">NO</span>' 
                                !!}
                            </p>
                            <p><strong>Lead Created:</strong> {{ $lead->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    @if($lead->mobile)
                        <a href="tel:{{ $lead->mobile }}" class="btn btn-success">
                            <i class="bi bi-telephone-fill me-1"></i> Call Lead
                        </a>
                    @endif
                    
                    @if($lead->payment_status !== 'paid')
                        <span class="text-muted ms-3 small italic">Payment is still pending for this lead.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>