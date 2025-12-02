<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Blog Categories') }}</h2>
    </x-slot>

    <div class="content"> {{-- AdminLTE content wrapper class --}}
        <div class="container-fluid"> {{-- AdminLTE container for fluid layout --}}
            <div class="card card-primary card-outline"> {{-- AdminLTE Card styling --}}

                {{-- AdminLTE: Card Header for Title, Search, and Create Button --}}
                <div class="card-header">
                    <h3 class="card-title">Category List</h3>

                    {{-- AdminLTE Card Tools (for search and create button) --}}
                    <div class="card-tools d-flex align-items-center">
                        {{-- Search Form with Clear Button --}}
                        <form action="{{ route('admin.blog-categories.index') }}" method="GET" class="d-flex align-items-center me-2">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="search" name="search" class="form-control float-right"
                                    placeholder="Search by name or slug..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit" title="Search">
                                        <i class="fas fa-search"></i> {{-- Font Awesome Search Icon --}}
                                    </button>
                                    {{-- Clear Button: Only show if search query exists --}}
                                    @if(request('search'))
                                        <a href="{{ route('admin.blog-categories.index', array_merge(request()->except(['search', 'page']), ['search' => ''])) }}"
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
                        <a href="{{ route('admin.blog-categories.create') }}" class="btn btn-sm btn-success" title="Create Category">
                            <i class="fas fa-plus"></i> Create
                        </a>
                    </div>
                </div>

                <div class="card-body p-0"> {{-- Full-width table with no padding --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle"> {{-- AdminLTE table classes --}}
                            <thead>
                                <tr>
                                    @php
                                        $sortableColumns = [
                                            'id' => 'ID',
                                            'name' => 'Name',
                                            'slug' => 'Slug',
                                            'created_at' => 'Created At',
                                        ];
                                        $sortBy = request('sort_by', 'id');
                                        $sortDirection = request('sort_direction', 'asc');

                                        $sort = function($column, $label) use ($sortBy, $sortDirection) {
                                            $dir = ($column == $sortBy && $sortDirection == 'asc') ? 'desc' : 'asc';
                                            $query = array_merge(request()->query(), ['sort_by' => $column, 'sort_direction' => $dir]);
                                            $icon = '';
                                            if ($column == $sortBy) {
                                                $icon = $dir == 'asc' ? '<i class="fas fa-arrow-up fa-xs ms-1"></i>' : '<i class="fas fa-arrow-down fa-xs ms-1"></i>';
                                            }
                                            return '<a class="text-decoration-none text-dark fw-semibold" href="' . route('admin.blog-categories.index', $query) . '">' . $label . ' ' . $icon . '</a>';
                                        };
                                    @endphp
                                    @foreach($sortableColumns as $column => $label)
                                        <th>{!! $sort($column, $label) !!}</th>
                                    @endforeach
                                    <th>Description</th>
                                    <th class="text-center" style="width: 150px;">Actions</th> {{-- Fixed width for actions --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>
                                           
                                                {{ $category->name }}
                                         
                                        </td>
                                        <td>{{ $category->slug }}</td>
                                      
                                        <td>{{ $category->created_at->format('Y-m-d') }}</td>
                                          <td>{{ Str::limit($category->description, 50) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Category Actions">
                                                  <a href="{{ route('admin.blog-categories.show', $category) }}"
                                                    class="btn btn-sm btn-primary me-2" data-toggle="tooltip" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.blog-categories.edit', $category) }}"
                                                    class="btn btn-sm btn-info me-2" data-toggle="tooltip" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.blog-categories.destroy', $category) }}" method="POST"
                                                    class="d-inline" id="delete-form-{{ $category->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        data-toggle="tooltip" title="Delete"
                                                        onclick="return showConfirmationModal('delete-form-{{ $category->id }}', '{{ Str::limit($category->name, 60) }}', 'Blog Category')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No categories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- AdminLTE: Card Footer for Pagination --}}
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>