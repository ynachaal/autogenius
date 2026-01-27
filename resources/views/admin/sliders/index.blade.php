<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Slides') }}</h2>
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">

                {{-- Card Header --}}
                <div class="card-header">
                    <h3 class="card-title">Slide List</h3>

                    <div class="card-tools d-flex align-items-center">
                        {{-- Search & Category Filter Form --}}
                        <form action="{{ route('admin.sliders.index') }}" method="GET" class="d-flex align-items-center me-2">
                            
                            {{-- Category Filter Dropdown --}}
                            <select name="category" class="form-control form-control-sm me-2" style="width: 160px;" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach($categories_list as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="search" name="search" class="form-control float-right"
                                    placeholder="Search heading..." value="{{ request('search') }}">
                                
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit" title="Search">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                    
                                    @if(request('search') || request('category'))
                                        <a href="{{ route('admin.sliders.index', request()->except(['search', 'category', 'page'])) }}" 
                                           class="btn btn-secondary btn-sm" title="Clear All Filters">Clear</a>
                                    @endif
                                </div>

                                {{-- Preserve Sort state --}}
                                @if(request('sort_by'))
                                    <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                @endif
                                @if(request('sort_direction'))
                                    <input type="hidden" name="sort_direction" value="{{ request('sort_direction') }}">
                                @endif
                            </div>
                        </form>

                        {{-- Create Button --}}
                    <!--     <a href="{{ route('admin.sliders.create') }}" class="btn btn-sm btn-success" title="Create Slider">
                            <i class="fas fa-plus"></i> Create
                        </a> -->
                    </div>
                </div>

                {{-- Table Body --}}
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    @php
                                        $sortableColumns = [
                                            'id' => 'ID',
                                            'slider_category_id' => 'Category',
                                            'type' => 'Type',
                                      /*       'heading' => 'Heading', */
                                            'status' => 'Status',
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
                                            return '<a class="text-decoration-none text-dark fw-semibold" href="' . route('admin.sliders.index', $query) . '">' . $label . ' ' . $icon . '</a>';
                                        };
                                    @endphp
                                    
                                 
                                    <th style="width: 100px;">Preview</th>
                                    @foreach($sortableColumns as $column => $label)
                                        <th>{!! $sort($column, $label) !!}</th>
                                    @endforeach
                                    <th class="text-center" style="width: 160px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sliders as $index => $slider)
                                    <tr>
                                           <td>
                                            @if($slider->type == 'image')
                                                <img src="{{ asset('storage/'.$slider->file) }}" class="rounded border shadow-sm" width="80" height="45" style="object-fit: cover;">
                                            @else
                                                <div class="bg-dark rounded text-center d-flex align-items-center justify-content-center shadow-sm" style="width: 80px; height: 45px;">
                                                    <i class="fas fa-video text-white fa-xs"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $sliders->firstItem() + $index }}</td>
                                     
                                        <td>
                                            <span class="badge border text-dark bg-light">{{ $slider->category->name }}</span>
                                        </td>
                                        <td><span class="text-capitalize">{{ $slider->type }}</span></td>
                                     <!--    <td>
                                            @if($slider->heading)
                                                <strong>{{ Str::limit($slider->heading, 40) }}</strong>
                                            @else
                                                <span class="text-muted small"><em>N/A</em></span>
                                            @endif
                                        </td> -->
                                        <td>
                                            <span class="badge bg-{{ $slider->status ? 'success' : 'danger' }}">
                                                {{ $slider->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $slider->created_at->format('Y-m-d') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                {{-- Show/View Button --}}
                                                <a href="{{ route('admin.sliders.show', $slider) }}" class="btn btn-sm btn-primary me-2" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                
                                                {{-- Edit Button --}}
                                                <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-info me-2" title="Edit">
                                                    <i class="bi bi-pencil text-white"></i>
                                                </a>
                                                
                                                {{-- Delete Button --}}
                                              <!--   <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline" id="delete-form-{{ $slider->id }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this slider?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form> -->
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="9" class="text-center py-4">No sliders found matching your criteria.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="card-footer clearfix">
                    <div class="float-left small text-muted">
                        Showing total <strong>{{ $sliders->total() }}</strong> sliders
                    </div>
                    <div class="float-right">
                        {{ $sliders->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>