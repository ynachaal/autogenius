<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Sell Your Car Inquiries') }}</h2>
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Inquiry List</h3>

                    <div class="card-tools d-flex align-items-center">
                        <form action="{{ route('admin.sell-your-cars.index') }}" method="GET" class="d-flex align-items-center me-2">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="search" name="search" class="form-control float-right"
                                    placeholder="Search vehicle or customer..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if(request('search'))
                                        <a href="{{ route('admin.sell-your-cars.index') }}" class="btn btn-secondary btn-sm">Clear</a>
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
                                    @php
                                        $sortableColumns = [
                                            'id' => 'Sr No.',
                                            'vehicle_name' => 'Vehicle',
                                            'year' => 'Year',
                                            'customer_name' => 'Customer',
                                            'created_at' => 'Date',
                                        ];
                                        $sortBy = request('sort_by', 'created_at');
                                        $sortDirection = request('sort_direction', 'desc');

                                        $sort = function ($column, $label) use ($sortBy, $sortDirection) {
                                            $dir = ($column == $sortBy && $sortDirection == 'asc') ? 'desc' : 'asc';
                                            $query = array_merge(request()->query(), ['sort_by' => $column, 'sort_direction' => $dir]);
                                            $icon = ($column == $sortBy) ? ($dir == 'asc' ? '<i class="fas fa-arrow-up fa-xs"></i>' : '<i class="fas fa-arrow-down fa-xs"></i>') : '';
                                            return '<a class="text-decoration-none text-dark fw-semibold" href="' . route('admin.sell-your-cars.index', $query) . '">' . $label . ' ' . $icon . '</a>';
                                        };
                                    @endphp

                                    @foreach($sortableColumns as $column => $label)
                                        <th>{!! $sort($column, $label) !!}</th>
                                    @endforeach
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inquiries as $index => $item)
                            
                                    <tr>
                                        <td>{{ $inquiries->firstItem() + $index }}</td>
                                        <td><strong>{{ $item->vehicle_name }}</strong></td>
                                        <td>{{ $item->year }}</td>
                                        <td>{{ $item->customer_name }}</td>
                                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.sell-your-cars.show', $item) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No inquiries found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $inquiries->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>