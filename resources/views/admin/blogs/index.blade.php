<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Blogs') }}</h2>
    </x-slot>

    <div class="content"> {{-- AdminLTE content wrapper class --}}
        <div class="container-fluid"> {{-- AdminLTE container for fluid layout --}}
            <div class="card card-primary card-outline"> {{-- AdminLTE Card styling --}}

                {{-- AdminLTE: Card Header for Title, Search, and Create Button --}}
                <div class="card-header">
                    <h3 class="card-title">Blog List</h3>

                    {{-- AdminLTE Card Tools (for search and create button) --}}
                    <div class="card-tools d-flex align-items-center">

                        {{-- MODIFIED SEARCH FORM WITH CLEAR BUTTON --}}
                        <form action="{{ route('admin.blogs.index') }}" method="GET" class="d-flex align-items-center me-2">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="search" name="search" class="form-control float-right"
                                    placeholder="Search by title or author..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit">
                                        <i class="fas fa-search"></i> {{-- Search Button --}}
                                    </button>

                                    {{-- NEW: Clear Button. Only show if a search query is present --}}
                                    @if(request('search'))
                                    <a href="{{ route('admin.blogs.index', array_merge(request()->except(['search', 'page']), ['search' => ''])) }}" class="btn-sm btn btn-secondary" title="Clear Search">
                                        Clear
                                    </a>
                                    @endif

                                </div>
                                {{-- Hidden fields to preserve sorting while searching or clearing --}}
                                @if(request('sort_by'))
                                    <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                @endif
                                @if(request('sort_direction'))
                                    <input type="hidden" name="sort_direction" value="{{ request('sort_direction') }}">
                                @endif
                            </div>
                        </form>
                        {{-- END MODIFIED SEARCH FORM --}}

                        {{-- CREATE BUTTON (moved after the search form) --}}
                        <a href="{{ route('admin.blogs.create') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Create
                        </a>
                    </div>
                </div>
                <div class="card-body p-0"> {{-- Use p-0 to make the table span full width within the card body --}}

                    <div class="table-responsive">
                        {{-- AdminLTE table classes: table-hover, table-head-fixed, table-striped --}}
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    @php
                                         // Existing sortable columns logic...
                                         $sortableColumns = [
                                             'id' => 'ID',
                                             'title' => 'Title',
                                             'author' => 'Author',
                                             'category' => 'Category',
                                             'is_published' => 'Published',
                                             'created_at' => 'Created At'
                                         ];
                                         $sortBy = request('sort_by', 'id');
                                         $sortDirection = request('sort_direction', 'asc');

                                         $sort = function ($column, $label) use ($sortBy, $sortDirection) {
                                             $dir = ($column == $sortBy && $sortDirection == 'asc') ? 'desc' : 'asc';
                                             $query = array_merge(request()->query(), ['sort_by' => $column, 'sort_direction' => $dir]);
                                             $icon = '';
                                             // AdminLTE often uses fa-arrow-up/down
                                             if ($column == $sortBy) {
                                                 $icon = $dir == 'asc' ? '<i class="fas fa-arrow-up fa-xs ms-1"></i>' : '<i class="fas fa-arrow-down fa-xs ms-1"></i>';
                                             }
                                             return '<a class="text-decoration-none text-dark fw-semibold" href="' . route('admin.blogs.index', $query) . '">' . $label . ' ' . $icon . '</a>';
                                         };
                                    @endphp
                                    @foreach($sortableColumns as $column => $label)
                                        <th>{!! $sort($column, $label) !!}</th>
                                    @endforeach
                                    <th class="text-center" style="width: 150px;">Actions</th> {{-- Explicit width for
                                    actions --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blogs as $blog)
                                    <tr>
                                        <td>{{ $blog->id }}</td>
                                        <td>
                                         
                                                {{ $blog->title }}
                                           
                                        </td>
                                        <td>{{ $blog->author->name ?? 'N/A' }}</td>
                                        <td>{{ $blog->category->name ?? '-' }}</td>
                                        <td>
                                            @if($blog->is_published)
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-warning">No</span> {{-- AdminLTE badge classes --}}
                                            @endif
                                        </td>
                                        <td>{{ $blog->created_at->format('Y-m-d') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                  <a href="{{ route('admin.blogs.show', $blog) }}"
                                                    class="btn btn-sm btn-primary me-2" data-toggle="tooltip" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.blogs.edit', $blog) }}"
                                                    class="btn btn-sm btn-info me-2" data-toggle="tooltip" title="Edit">
                                                    <i class="nav-arrow bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST"
                                                    class="d-inline" id="delete-form-{{ $blog->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        data-toggle="tooltip" title="Delete"
                                                        onclick="return showConfirmationModal('delete-form-{{ $blog->id }}', '{{ Str::limit($blog->title, 60) }}', 'Blog')">
                                                        <i class="nav-arrow bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No blogs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- AdminLTE: Card Footer for Pagination --}}
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $blogs->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>