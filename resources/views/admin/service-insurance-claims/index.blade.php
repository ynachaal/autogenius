<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Insurance Claim Requests') }}</h2>
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Claims List</h3>
                    <div class="card-tools d-flex">
                        <form action="{{ route('admin.service-insurance-claims.index') }}" method="GET" class="d-flex me-2">
                            <input type="search" name="search" class="form-control form-control-sm me-1"
                                placeholder="Search customer..." value="{{ request('search') }}">
                            <button class="btn btn-sm btn-default" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Service Type</th>
                                <th>Documents</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($claims as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->customer_name }}</strong><br>
                                        <small class="text-muted">{{ $item->customer_mobile }}</small>
                                    </td>
                                    <td><span class="badge bg-info text-dark">{{ $item->service_type }}</span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if($item->rc_path) <i class="fas fa-file-invoice text-secondary" title="RC"></i> @endif
                                            @if($item->insurance_path) <i class="fas fa-shield-alt text-primary" title="Policy"></i> @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php $latestPayment = $item->payments->sortByDesc('created_at')->first(); @endphp

                                        @if($latestPayment && $latestPayment->status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($latestPayment && $latestPayment->status === 'pending')
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-secondary px-2">Pending</span>
                                                <form action="{{ route('admin.service-insurance-claims.verify-payment', [$item->id, $latestPayment->id]) }}" method="POST" class="ms-2 d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link p-0 text-info border-0" title="Verify Status">
                                                        <i class="fas fa-sync-alt fa-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
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
                                        <a href="{{ route('admin.service-insurance-claims.show', $item) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center">No insurance claims found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $claims->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>