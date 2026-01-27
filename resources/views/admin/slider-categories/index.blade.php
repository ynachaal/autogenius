<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Slider Categories') }}</h2>
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Category List</h3>

                    <div class="card-tools d-flex align-items-center">
                        {{-- Improved Search Form (Preserves Sort State) --}}
                        <form action="{{ route('admin.slider-categories.index') }}" method="GET" class="d-flex align-items-center me-2">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="search" name="search" class="form-control float-right"
                                    placeholder="Search categories..." value="{{ request('search') }}">
                                
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit" title="Search">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                    
                                    @if(request('search'))
                                        <a href="{{ route('admin.slider-categories.index', request()->except(['search', 'page'])) }}" class="btn btn-secondary btn-sm">Clear</a>
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

                       <!--  <a href="{{ route('admin.slider-categories.create') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Create
                        </a> -->
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    @php
                                        $sortableColumns = [
                                            'id' => 'ID',
                                            'name' => 'Category Name',
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
                                            return '<a class="text-dark fw-semibold text-decoration-none" href="' . route('admin.slider-categories.index', $query) . '">' . $label . ' ' . $icon . '</a>';
                                        };
                                    @endphp
                                    
                                    @foreach($sortableColumns as $column => $label)
                                        <th>{!! $sort($column, $label) !!}</th>
                                    @endforeach
                                    <th class="text-center" style="width: 160px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $index =>$category)
                                    <tr>
                                         <td>{{ $categories->firstItem() + $index }}</td>
                                        <td>
                                            @if($category->name)
                                                <strong>{{ $category->name }}</strong>
                                            @else
                                                <span class="text-muted small"><em>N/A</em></span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $category->status ? 'success' : 'danger' }}">
                                                {{ $category->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $category->created_at->format('Y-m-d') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                {{-- Show Button --}}
                                                <a href="{{ route('admin.slider-categories.show', $category) }}" class="btn btn-sm btn-primary me-2" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                {{-- Edit Button --}}
                                                <a href="{{ route('admin.slider-categories.edit', $category) }}" class="btn btn-sm btn-info me-2" title="Edit">
                                                    <i class="bi bi-pencil text-white"></i>
                                                </a>
                                                
                                                {{-- Delete Button --}}
                                               <!--  <form action="{{ route('admin.slider-categories.destroy', $category) }}" method="POST" class="d-inline" id="delete-cat-{{ $category->id }}">
                                                    @csrf @method('DELETE')
                                                  <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                          onclick="return confirm('This action cannot be undone. Delete this category?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                                </form> -->
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center ">No categories found matching your criteria.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-left small text-muted">
                        Showing total <strong>{{ $categories->total() }}</strong> categories
                    </div>
                    <div class="float-right">
                        {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>