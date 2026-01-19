<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Contact Submissions') }}</h2>
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Inquiry List</h3>

                    <div class="card-tools d-flex align-items-center">
                        {{-- Search Form --}}
                         <form action="{{ route('admin.contact-submissions.index') }}" method="GET"
                            class="d-flex align-items-center me-2">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="search" name="search" class="form-control float-right"
                                    placeholder="Search by title..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit" title="Search">
                                        <i class="fas fa-search"></i> Search
                                    </button>

                                    @if(request('search'))
                                        <a href="{{ route('admin.contact-submissions.index', array_merge(request()->except(['search', 'page']), ['search' => ''])) }}"
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
                                            'name' => 'Sender',
                                            'email' => 'Email',
                                            'is_read' => 'Status',
                                            'created_at' => 'Date',
                                        ];
                                        $sortBy = request('sort_by', 'created_at');
                                        $sortDirection = request('sort_direction', 'desc');

                                        $sort = function ($column, $label) use ($sortBy, $sortDirection) {
                                            $dir = ($column == $sortBy && $sortDirection == 'asc') ? 'desc' : 'asc';
                                            $query = array_merge(request()->query(), ['sort_by' => $column, 'sort_direction' => $dir]);
                                            $icon = ($column == $sortBy) ? ($dir == 'asc' ? '<i class="fas fa-arrow-up fa-xs ms-1"></i>' : '<i class="fas fa-arrow-down fa-xs ms-1"></i>') : '';
                                            return '<a class="text-decoration-none text-dark fw-semibold" href="' . route('admin.contact-submissions.index', $query) . '">' . $label . ' ' . $icon . '</a>';
                                        };
                                    @endphp

                                    @foreach($sortableColumns as $column => $label)
                                        <th>{!! $sort($column, $label) !!}</th>
                                    @endforeach
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($submissions as $submission)
                                    <tr class="{{ $submission->is_read ? 'text-muted' : 'fw-bold' }}">
                                        <td>{{ $submission->id }}</td>
                                        <td>{{ $submission->name }}</td>
                                        <td>{{ $submission->email }}</td>
                                        <td>
                                            @if($submission->is_read)
                                                <span class="badge bg-secondary">Read</span>
                                            @else
                                                <span class="badge bg-success">New</span>
                                            @endif
                                        </td>
                                        <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.contact-submissions.show', $submission) }}" 
                                                   class="btn btn-sm btn-primary me-2" title="View Message">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.contact-submissions.destroy', $submission) }}" 
                                                      method="POST" class="d-inline" id="delete-form-{{ $submission->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return showConfirmationModal('delete-form-{{ $submission->id }}', '{{ $submission->email }}', 'Submission')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No submissions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $submissions->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>