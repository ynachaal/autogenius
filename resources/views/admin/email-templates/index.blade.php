<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Email Templates') }}</h2>
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Email Template List</h3>

                    <div class="card-tools d-flex align-items-center">
                        {{-- Unified Search & Filter Form --}}
                        <form action="{{ route('admin.email-templates.index') }}" method="GET" class="d-flex align-items-center me-2">
                            <div class="input-group input-group-sm" style="width: 450px;">
                                <input type="search" name="search" class="form-control"
                                    placeholder="Search by title..." value="{{ request('search') }}">
                                
                                <select name="is_published" class="form-select form-select-sm">
                                    <option value="" {{ request('is_published') === null ? 'selected' : '' }}>All Statuses</option>
                                    <option value="1" {{ request('is_published') === '1' ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ request('is_published') === '0' ? 'selected' : '' }}>Unpublished</option>
                                </select>
                                
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit"><i class="fas fa-search"></i> Search</button>
                                    
                                    @if(request('search') || request('is_published') !== null)
                                        <a href="{{ route('admin.email-templates.index', request()->except(['search', 'is_published', 'page'])) }}" 
                                           class="btn btn-secondary btn-sm">Clear</a>
                                    @endif
                                </div>

                                {{-- Hidden fields to keep sorting active --}}
                                @if(request('sort_by'))
                                    <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                @endif
                                @if(request('sort_direction'))
                                    <input type="hidden" name="sort_direction" value="{{ request('sort_direction') }}">
                                @endif
                            </div>
                        </form>

                        {{-- Create button hidden as per your original logic, but styled to match Brands --}}
                        <a href="{{ route('admin.email-templates.create') }}" class="btn btn-sm btn-success" style="display: none">
                            <i class="fas fa-plus"></i> Create
                        </a>
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
                                            'title' => 'Title',
                                            'is_published' => 'Status',
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
                                            return '<a class="text-dark fw-semibold text-decoration-none" href="' . route('admin.email-templates.index', $query) . '">' . $label . ' ' . $icon . '</a>';
                                        };
                                    @endphp
                                    
                                    @foreach($sortableColumns as $column => $label)
                                        <th>{!! $sort($column, $label) !!}</th>
                                    @endforeach
                                    <th class="text-center" style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($emailTemplates as $index => $template)
                                    <tr>
                                        <td>{{ $emailTemplates->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ Str::limit($template->title, 50) }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $template->is_published ? 'success' : 'warning' }}">
                                                {{ $template->is_published ? 'Published' : 'Draft' }}
                                            </span>
                                        </td>
                                        <td>{{ $template->created_at->format('Y-m-d') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.email-templates.show', $template) }}" class="btn btn-sm btn-primary me-1" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                
                                                {{-- Edit and Delete buttons (commented/hidden based on your original file) --}}
                                                {{-- <a href="{{ route('admin.email-templates.edit', $template) }}" class="btn btn-sm btn-info me-1" title="Edit"><i class="bi bi-pencil"></i></a> --}}
                                                
                                                <form action="{{ route('admin.email-templates.destroy', $template) }}" method="POST" class="d-inline" id="delete-form-{{ $template->id }}">
                                                    @csrf @method('DELETE')
                                                    {{-- <button type="submit" class="btn btn-sm btn-danger" onclick="return showConfirmationModal(...)"><i class="bi bi-trash"></i></button> --}}
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No email templates found matching your criteria.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $emailTemplates->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>