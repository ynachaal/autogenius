<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Consultation Requests') }}</h2>
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Consultation List</h3>

                    <div class="card-tools d-flex align-items-center">
                        {{-- Search Form --}}
                        <form action="{{ route('admin.consultations.index') }}" method="GET"
                            class="d-flex align-items-center me-2">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="search" name="search" class="form-control float-right"
                                    placeholder="Search by name, email, subject..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-default" type="submit" title="Search">
                                        <i class="fas fa-search"></i> Search
                                    </button>

                                    @if(request('search'))
                                        <a href="{{ route('admin.consultations.index', array_merge(request()->except(['search', 'page']), ['search' => ''])) }}"
                                            class="btn-sm btn btn-secondary" title="Clear Search">
                                            Clear
                                        </a>
                                    @endif
                                </div>

                                {{-- Hidden fields to preserve sorting/status --}}
                                @if(request('sort_by'))
                                    <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                @endif
                                @if(request('sort_direction'))
                                    <input type="hidden" name="sort_direction" value="{{ request('sort_direction') }}">
                                @endif
                                @if(request('status'))
                                    <input type="hidden" name="status" value="{{ request('status') }}">
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
                                            'name' => 'Client',
                                            'subject' => 'Subject',
                                            'preferred_date' => 'Pref. Date',
                                            'status' => 'Status',
                                            'created_at' => 'Received',
                                        ];
                                        $sortBy = request('sort_by', 'created_at');
                                        $sortDirection = request('sort_direction', 'desc');

                                        $sort = function ($column, $label) use ($sortBy, $sortDirection) {
                                            $dir = ($column == $sortBy && $sortDirection == 'asc') ? 'desc' : 'asc';
                                            $query = array_merge(request()->query(), ['sort_by' => $column, 'sort_direction' => $dir]);
                                            $icon = ($column == $sortBy) ? ($dir == 'asc' ? '<i class="fas fa-arrow-up fa-xs ms-1"></i>' : '<i class="fas fa-arrow-down fa-xs ms-1"></i>') : '';
                                            return '<a class="text-decoration-none text-dark fw-semibold" href="' . route('admin.consultations.index', $query) . '">' . $label . ' ' . $icon . '</a>';
                                        };
                                    @endphp

                                    @foreach($sortableColumns as $column => $label)
                                        <th>{!! $sort($column, $label) !!}</th>
                                    @endforeach
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($consultations as $consultation)
                                    <tr>
                                        <td>{{ $consultation->id }}</td>
                                        <td>
                                            {{ $consultation->name }}<br>
                                            <small class="text-muted">{{ $consultation->email }}</small>
                                        </td>
                                        <td>{{ Str::limit($consultation->subject, 30) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($consultation->preferred_date)->format('Y-m-d') }}</td>
                                        <td>
                                            @php
                                                $badgeClass = match($consultation->status) {
                                                    'pending' => 'bg-warning text-dark',
                                                    'completed' => 'bg-success',
                                                    'cancelled' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ ucfirst($consultation->status) }}</span>
                                        </td>
                                        <td>{{ $consultation->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.consultations.show', $consultation) }}" 
                                                   class="btn btn-sm btn-primary me-2" title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.consultations.destroy', $consultation) }}" 
                                                      method="POST" class="d-inline" id="delete-form-{{ $consultation->id }}">
                                                    @csrf
                                                   <!--  @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this submission ({{ $consultation->email }})?')">
                                                    <i class="bi bi-trash"></i>
                                                </button> -->

                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No consultation requests found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $consultations->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>