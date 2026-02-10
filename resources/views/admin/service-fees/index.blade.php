<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Service Fee Management') }}</h2>
    </x-slot>

    <div class="content"> {{-- AdminLTE content wrapper class --}}
        <div class="container-fluid"> {{-- AdminLTE container for fluid layout --}}
            <div class="card card-primary card-outline shadow-sm"> {{-- AdminLTE Card styling --}}

                {{-- AdminLTE: Card Header for Title, Search, and Create Button --}}
                <div class="card-header">
                    <h3 class="card-title">Fee Structure List</h3>

                    <div class="card-tools d-flex align-items-center">
                        {{-- Search Form with Clear Button --}}
                        <form action="{{ route('admin.service-fees.index') }}" method="GET" 
                            class="d-flex align-items-center me-2">
                            
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="search" name="search" class="form-control float-right" 
                                    placeholder="Search by segment..." value="{{ request('search') }}">

                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit" title="Search">
                                        <i class="fas fa-search"></i>
                                        Search
                                    </button>

                                    @if(request('search'))
                                        <a href="{{ route('admin.service-fees.index', array_merge(request()->except(['search', 'page']), ['search' => ''])) }}" 
                                            class="btn-sm btn btn-secondary" title="Clear Search">
                                            Clear
                                        </a>
                                    @endif
                                </div>

                                {{-- Hidden fields to preserve sorting --}}
                                @if(request('sort_by'))
                                    <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                @endif
                                @if(request('sort_direction'))
                                    <input type="hidden" name="sort_direction" value="{{ request('sort_direction') }}">
                                @endif
                            </div>
                        </form>

                        {{-- Create Button --}}
                        <a href="{{ route('admin.service-fees.create') }}" class="btn btn-sm btn-success" 
                            title="Create New Fee">
                            <i class="fas fa-plus"></i> Create
                        </a>
                    </div>
                </div>

                <div class="card-body p-0"> {{-- Full-width table --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    @php
                                        $sortableColumns = [
                                            'id' => 'ID',
                                            'car_segment' => 'Car Segment',
                                            'full_report_fee' => 'Report Fee',
                                            'booking_amount' => 'Booking Amount',
                                            'status' => 'Status',
                                        ];
                                        $sortBy = request('sort_by', 'id');
                                        $sortDirection = request('sort_direction', 'asc');

                                        $sort = function ($column, $label) use ($sortBy, $sortDirection) {
                                            $dir = ($column == $sortBy && $sortDirection == 'asc') ? 'desc' : 'asc';
                                            $query = array_merge(request()->query(), ['sort_by' => $column, 'sort_direction' => $dir]);
                                            $icon = '';
                                            if ($column == $sortBy) {
                                                $icon = $dir == 'asc' ? '<i class="fas fa-arrow-up fa-xs ms-1"></i>' : '<i class="fas fa-arrow-down fa-xs ms-1"></i>';
                                            }
                                            return '<a class="text-decoration-none text-dark fw-semibold" href="' . route('admin.service-fees.index', $query) . '">' . $label . ' ' . $icon . '</a>';
                                        };
                                    @endphp
                                    
                                    @foreach($sortableColumns as $column => $label)
                                        <th>{!! $sort($column, $label) !!}</th>
                                    @endforeach
                                    <th class="text-center" style="width: 180px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fees as $index => $fee)
                                    <tr>
                                        <td>{{ $fees->firstItem() + $index }}</td>
                                        <td><strong>{{ $fee->car_segment }}</strong></td>
                                        <td>₹{{ number_format($fee->full_report_fee, 2) }}</td>
                                        <td>₹{{ number_format($fee->booking_amount, 2) }}</td>
                                        <td>
                                            <span class="badge {{ $fee->status ? 'bg-success' : 'bg-danger' }}">
                                                {{ $fee->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.service-fees.show', $fee) }}" 
                                                    class="btn btn-sm btn-primary me-1" data-toggle="tooltip" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.service-fees.edit', $fee) }}" 
                                                    class="btn btn-sm btn-info me-1" data-toggle="tooltip" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.service-fees.destroy', $fee) }}" 
                                                    method="POST" class="d-inline" id="delete-form-{{ $fee->id }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                        data-toggle="tooltip" title="Delete"
                                                        onclick="return confirm('Delete fee for: {{ $fee->car_segment }}?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">No service fees configured.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- AdminLTE: Card Footer for Pagination --}}
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $fees->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>