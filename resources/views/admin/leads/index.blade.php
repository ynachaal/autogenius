<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Vehicle Purchase Leads') }}</h2>
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Leads List</h3>
                    <div class="card-tools d-flex align-items-center">
                        <form action="{{ route('admin.leads.index') }}" method="GET"
                            class="d-flex align-items-center me-2">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="search" name="search" class="form-control float-right"
                                    placeholder="Search name, mobile or city..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if(request('search'))
                                        <a href="{{ route('admin.leads.index') }}"
                                            class="btn btn-secondary btn-sm">Clear</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Customer</th>
                                    <th>City</th>
                                    <th>Budget</th>
                                    <th>Service</th>
                                    <th>Timeline</th>
                                    <th>Payment</th>
                                    <th>Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($submissions as $index => $lead)
                                    <tr>
                                        <td>{{ $submissions->firstItem() + $index }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $lead->full_name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $lead->mobile ?? 'N/A' }}</small>
                                        </td>
                                        <td>{{ $lead->city ?? 'N/A' }}</td>
                                        <td>
                                            @if($lead->budget && $lead->budget > 0)
                                                ₹{{ number_format($lead->budget) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $lead->service_required ?? 'N/A' }}</td>
                                        <td>
                                            @if($lead->purchase_timeline)
                                                <span class="badge bg-warning text-dark">{{ $lead->purchase_timeline }}</span>
                                            @else
                                                <span class="text-muted small">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($lead->payment_status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($lead->payment_status == 'pending')
                                                <span class="badge bg-secondary">Pending</span>
                                            @else
                                                <span class="badge bg-light text-dark">{{ ucfirst($lead->payment_status ?? 'Unpaid') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $lead->created_at ? $lead->created_at->format('Y-m-d') : 'N/A' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No leads found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $submissions->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>