<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Car Inspection Requests') }}</h2>
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">Inspections List</h3>
                    <div class="card-tools d-flex">
                        <form action="{{ route('admin.car-inspections.index') }}" method="GET" class="d-flex me-2">
                            <input type="search" name="search" class="form-control form-control-sm me-1"
                                placeholder="Search customer or vehicle..." value="{{ request('search') }}">
                            <button class="btn btn-sm btn-default" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Vehicle</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inspections as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->customer_name }}</strong><br>
                                        <small class="text-muted">{{ $item->customer_mobile }}</small>
                                    </td>
                                    <td>{{ $item->vehicle_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->inspection_date)->format('d M Y') }}</td>
                                    <td>{{ $item->inspection_location }}</td>
                                    <td>
                                        @php
                                            // Get the latest payment record for this inspection
                                            $latestPayment = $item->payments->sortByDesc('created_at')->first();
                                        @endphp

                                        @if($latestPayment && $latestPayment->status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($latestPayment && $latestPayment->status === 'pending')
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-secondary px-2" style="font-weight: 500;">Pending</span>

                                                <form
                                                    action="{{ route('admin.car-inspections.verify-payment', [$item->id, $latestPayment->id]) }}"
                                                    method="POST" class="ms-2 d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link p-0 text-info border-0"
                                                        title="Verify Status" style="line-height: 1; vertical-align: middle;">
                                                        <i class="fas fa-sync-alt fa-sm transition-rotate"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($latestPayment && $latestPayment->status === 'failed')
                                            <span class="badge bg-danger">Failed</span>
                                        @else
                                            <span class="badge bg-light text-dark">Unpaid</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $item->status == 'pending' ? 'bg-warning' : 'bg-primary' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.car-inspections.show', $item) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No inspections found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $inspections->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>