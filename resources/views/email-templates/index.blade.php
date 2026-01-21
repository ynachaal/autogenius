<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-medium mb-0 text-dark">{{ __('Email Templates') }}</h2>
    </x-slot>
    <div class="content">
        <div>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Email Template List</h3>
                    <div class="card-tools d-flex align-items-center">
                        <form action="{{ route('admin.email-templates.index') }}" method="GET" class="d-flex align-items-center me-2">
                            <div class="input-group input-group-sm me-2" style="width: 150px;">
                                <input type="search" name="search" class="form-control float-right"
                                       placeholder="Search by title..." value="{{ request('search') }}">
                            </div>

                            <div class="input-group input-group-sm me-2" style="width: 150px;">
                                <select name="is_published" class="form-control">
                                    <option value="" {{ request('is_published') === null ? 'selected' : '' }}>All Statuses</option>
                                    <option value="1" {{ request('is_published') === '1' ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ request('is_published') === '0' ? 'selected' : '' }}>Unpublished</option>
                                </select>
                            </div>
                            <button class="btn btn-primary me-1" type="submit" title="Apply Filters">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <div class="input-group-append">
                                @if(request('search') || request('is_published') !== null)
                                    <a href="{{ route('admin.email-templates.index', array_merge(request()->except(['search','is_published', 'page']))) }}"
                                       class="btn btn-secondary ms-1 me-1" title="Clear Search and Filters">
                                        Clear
                                    </a>
                                @endif
                            </div>
                            @if(request('sort_by'))
                                <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                            @endif
                            @if(request('sort_direction'))
                                <input type="hidden" name="sort_direction" value="{{ request('sort_direction') }}">
                            @endif
                        </form>
                        <a href="{{ route('admin.email-templates.create') }}" class="btn btn-success" title="Create Template" style="display: none">
                            <i class="fas fa-plus"></i> Create
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    @php
                                        $sortableColumns = [
                                            'id' => 'ID',
                                            'title' => 'Title',
                                            'is_published' => 'Published',
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
                                            return '<a class="text-decoration-none text-dark fw-medium" href="' . route('admin.email-templates.index', $query) . '">' . $label . ' ' . $icon . '</a>';
                                        };
                                    @endphp
                                    @foreach($sortableColumns as $column => $label)
                                        <th>{!! $sort($column, $label) !!}</th>
                                    @endforeach
                                    <th class="text-center" style="width: 150px; min-width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($emailTemplates as $index => $template)
                                    <tr>
                                        <td>{{ $emailTemplates->firstItem() + $index }}</td>
                                        <td>{{ Str::limit($template->title, 50) }}</td>
                                        <td>
                                            <span class="badge {{ $template->is_published ? 'bg-success' : 'bg-warning' }}">
                                                {{ $template->is_published ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td>{{ $template->created_at->format('Y-m-d') }}</td>
                                        <td class="text-center" style="width: 150px; min-width: 150px;">
                                            <div class="btn-group" role="group" aria-label="Email Template Actions">
                                                <a href="{{ route('admin.email-templates.show', $template) }}"
                                                   class="btn btn-sm btn-primary me-2" data-toggle="tooltip" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                {{-- <a href="{{ route('admin.email-templates.edit', $template) }}"
                                                   class="btn btn-sm btn-secondary me-2 bg-edit" data-toggle="tooltip" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a> --}}
                                                <form action="{{ route('admin.email-templates.destroy', $template) }}" method="POST"
                                                      class="d-inline" id="delete-form-{{ $template->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <!-- <button type="submit" class="btn btn-sm btn-danger"
                                                            data-toggle="tooltip" title="Delete"
                                                            onclick="return showConfirmationModal('delete-form-{{ $template->id }}', '{{ Str::limit($template->title, 60) }}', 'Email Template')">
                                                        <i class="bi bi-trash"></i>
                                                    </button> -->
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No email templates found.</td>
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
