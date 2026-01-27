<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Brands') }}</h2>
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Brand List</h3>

                    <div class="card-tools d-flex align-items-center">
                        {{-- Improved Search Form (Preserves Sort State) --}}
                        <form action="{{ route('admin.brands.index') }}" method="GET"
                            class="d-flex align-items-center me-2">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="search" name="search" class="form-control float-right"
                                    placeholder="Search brands..." value="{{ request('search') }}">

                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit"><i class="fas fa-search"></i>
                                        Search</button>

                                    @if(request('search'))
                                        {{-- Clear button keeps sorting but removes search/page --}}
                                        <a href="{{ route('admin.brands.index', request()->except(['search', 'page'])) }}"
                                            class="btn btn-secondary btn-sm">Clear</a>
                                    @endif
                                </div>

                                {{-- Hidden fields to keep sorting active during search --}}
                                @if(request('sort_by'))
                                    <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                @endif
                                @if(request('sort_direction'))
                                    <input type="hidden" name="sort_direction" value="{{ request('sort_direction') }}">
                                @endif
                            </div>
                        </form>

                        <a href="{{ route('admin.brands.create') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Create
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    @php
                                        $sortableColumns = [
                                            'id' => 'ID',
                                            'name' => 'Brand Name',
                                            'order' => 'Order',
                                            'status' => 'Status',
                                            'created_at' => 'Created',
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
                                            return '<a class="text-dark fw-semibold text-decoration-none" href="' . route('admin.brands.index', $query) . '">' . $label . ' ' . $icon . '</a>';
                                        };
                                    @endphp

                                    @foreach($sortableColumns as $column => $label)
                                        <th>{!! $sort($column, $label) !!}</th>
                                    @endforeach
                                    <th>Featured</th>
                                    <th class="text-center" style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($brands as $index => $brand)
                                    <tr>
                                        <td>
                                            @if($brand->image)
                                                {{-- FIXED: Removed 'storage/' because you store in 'uploads/' directly --}}
                                                <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}"
                                                    style="width: 40px; height: 40px; object-fit: cover;" class="img-thumbnail">
                                            @else
                                                <div class="bg-light text-center rounded border"
                                                    style="width: 40px; height: 40px; line-height: 40px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $brands->firstItem() + $index }}</td> {{-- Continuous numbering --}}
                                        <td>
                                            <strong>{{ $brand->name }}</strong><br>
                                            <small class="text-muted">{{ $brand->slug }}</small>
                                        </td>
                                        <td>{{ $brand->order ?? 0 }}</td>
                                        <td>
                                            <span class="badge bg-{{ $brand->status === 'active' ? 'success' : 'danger' }}">
                                                {{ ucfirst($brand->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $brand->created_at->format('Y-m-d') }}</td>
                                        <td class="text-left">
                                            @if($brand->is_featured)
                                                Yes
                                            @else
                                                No
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.brands.show', $brand) }}"
                                                    class="btn btn-sm btn-primary me-1" title="View"><i
                                                        class="bi bi-eye"></i></a>
                                                <a href="{{ route('admin.brands.edit', $brand) }}"
                                                    class="btn btn-sm btn-info me-1" title="Edit"><i
                                                        class="bi bi-pencil"></i></a>

                                                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST"
                                                    class="d-inline" id="delete-brand-{{ $brand->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this brand?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No brands found matching your criteria.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $brands->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>