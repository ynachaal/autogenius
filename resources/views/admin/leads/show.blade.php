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
                        <div class="col-md-4 border-end">
                            <h5 class="fw-bold text-primary mb-3">Customer Info</h5>
                            <p><strong>Mobile:</strong> {{ $lead->mobile ?? 'N/A' }}</p>
                            <p><strong>City:</strong> {{ $lead->city ?? 'N/A' }}</p>
                            <p><strong>Contact via:</strong> {{ $lead->preferred_contact_method ?? 'N/A' }}</p>
                            <p><strong>Decision Maker:</strong> {{ $lead->decision_maker ?? 'N/A' }}</p>
                            <hr>
                            <p><strong>Existing Car:</strong> {{ $lead->existing_car ?: 'N/A' }}</p>
                            <p><strong>Reason for Change:</strong><br>
                                <span class="text-muted">{{ $lead->upgrade_reason ?: 'N/A' }}</span>
                            </p>
                        </div>

                        <div class="col-md-8">
                            <h5 class="fw-bold text-primary mb-3">Vehicle Preferences</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p><strong>Budget Range:</strong> 
                                        @if($lead->budget)
                                            ₹{{ number_format($lead->budget) }} @if($lead->max_budget && $lead->max_budget > 0)
            - ₹{{ number_format($lead->max_budget) }}
        @endif
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <p><strong>Body Type:</strong> 
                                        {{ !empty($lead->body_type) ? implode(', ', (array)$lead->body_type) : 'N/A' }}
                                    </p>
                                    <p><strong>Fuel:</strong> 
                                        {{ !empty($lead->fuel_preference) ? implode(', ', (array)$lead->fuel_preference) : 'N/A' }}
                                    </p>
                                    <p><strong>Transmission:</strong> {{ $lead->gearbox ?? 'N/A' }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>Usage:</strong> {{ $lead->primary_usage ?? 'N/A' }} 
                                        ({{ $lead->approx_running ?? '0' }} KM/month)
                                    </p>
                                    <p><strong>Passengers:</strong> {{ $lead->passengers ?? 'N/A' }}</p>
                                    <p><strong>Ride Priority:</strong> {{ $lead->ride_comfort ?? 'N/A' }}</p>
                                    <p><strong>Timeline:</strong> {{ $lead->purchase_timeline ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-4 p-3 bg-light rounded border">
                                <h6 class="fw-bold">Prioritized Features & Specs:</h6>
                                <div class="mb-2">
                                    @php $features = (array)$lead->feature_priority; @endphp
                                    @forelse($features as $feature)
                                        <span class="badge bg-dark me-1">{{ $feature }}</span>
                                    @empty
                                        <span class="text-muted">N/A</span>
                                    @endforelse
                                </div>
                                <p class="mb-1 small"><strong>Noise Sensitivity:</strong> {{ $lead->noise_sensitivity ?? 'N/A' }}</p>
                                <p class="mb-1 small"><strong>Color Preference:</strong> {{ $lead->color_preference ?? 'N/A' }}</p>
                                <p class="mb-1 small">
                                    <strong>Max Owners:</strong> {{ $lead->max_owners ?? 'N/A' }} | 
                                    <strong>Accident History:</strong> {{ $lead->accident_history ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @if($lead->mobile)
                        <a href="tel:{{ $lead->mobile }}" class="btn btn-success">
                            <i class="bi bi-telephone-fill me-1"></i> Call Lead
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>