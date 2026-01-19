<x-app-layout>

    <x-slot name="header">
        <h2 class="h4">{{ __('Services') }}</h2>
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">

                {{-- Card Header --}}
                <div class="card-header">
                    <h3 class="card-title">Service List</h3>

                    <div class="card-tools d-flex align-items-center">
                        {{-- Search Form --}}
                        <form action="{{ route('admin.services.index') }}" method="GET"
                            class="d-flex align-items-center me-2">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="search" name="search" class="form-control float-right"
                                    placeholder="Search by title..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit" title="Search">
                                        <i class="fas fa-search"></i> Search
                                    </button>

                                    @if(request('search'))
                                        <a href="{{ route('admin.services.index', array_merge(request()->except(['search', 'page']), ['search' => ''])) }}"
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
                        <a href="{{ route('admin.services.create') }}" class="btn btn-sm btn-success"
                            title="Create Service">
                            <i class="fas fa-plus"></i> Create
                        </a>
                    </div>
                </div>

                {{-- Table --}}
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    @php
                                        $sortableColumns = [
                                            'id' => 'ID',
                                            'title' => 'Title',
                                            'status' => 'Status',
                                            'featured' => 'Featured',
                                            'created_at' => 'Created At',
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
                                            return '<a class="text-decoration-none text-dark fw-semibold" href="' . route('admin.services.index', $query) . '">' . $label . ' ' . $icon . '</a>';
                                        };
                                    @endphp

                                    @foreach($sortableColumns as $column => $label)
                                        <th>{!! $sort($column, $label) !!}</th>
                                    @endforeach

                                    <th>Sub Heading</th>
                                    <th class="text-center" style="width: 150px;">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($services as $index => $service)
                                    <tr>
                                        <td>{{ $services->firstItem() + $index }}</td>
                                        <td>{{ $service->title }}</td>
                                        <td>{{ $service->status ? 'Active' : 'Inactive' }}</td>
                                        <td>{{ $service->featured ? 'Yes' : 'No' }}</td>
                                        <td>{{ $service->created_at->format('Y-m-d') }}</td>
                                        <td>{{ Str::limit($service->sub_heading, 50) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Service Actions">
                                                <a href="{{ route('admin.services.show', $service) }}"
                                                    class="btn btn-sm btn-primary me-2" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.services.edit', $service) }}"
                                                    class="btn btn-sm btn-info me-2" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                                                    class="d-inline" id="delete-form-{{ $service->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this service?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No services found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $services->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>