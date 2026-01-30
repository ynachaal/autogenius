<x-app-layout>

    <x-slot name="header">

        <h2 class="h4">{{ __('Users') }}</h2>

    </x-slot>



    <div class="content">

        <div class="container-fluid">

            <div class="card card-primary card-outline">



                <div class="card-header">

                    <h3 class="card-title">User List</h3>



                    <div class="card-tools d-flex align-items-center">

                        <form action="{{ route('admin.users.index') }}" method="GET"
                            class="d-flex align-items-center me-2">

                            <div class="input-group input-group-sm" style="width: 250px;">

                                <input type="search" name="search" class="form-control float-right"
                                    placeholder="Search by name or email..." value="{{ request('search') }}">

                                <div class="input-group-append">

                                    <button class="btn btn-default" type="submit">

                                        <i class="fas fa-search"></i> Search

                                    </button>

                                    @if(request('search'))

                                        <a href="{{ route('admin.users.index', array_merge(request()->except(['search', 'page']), ['search' => ''])) }}"
                                            class="btn-sm btn btn-secondary" title="Clear Search">

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

                            </div>

                        </form>

                       <!--  <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success">

                            <i class="fas fa-plus"></i> Create

                        </a>
 -->
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

                                            'name' => 'Name',

                                            'email' => 'Email',

                                            'created_at' => 'Created At'

                                        ];

                                        $sortBy = request('sort_by', 'created_at');

                                        $sortDirection = request('sort_direction', 'desc');

                                        $sort = function ($column, $label) use ($sortBy, $sortDirection) {

                                            $dir = ($column == $sortBy && $sortDirection == 'asc') ? 'desc' : 'asc';

                                            $query = array_merge(request()->query(), ['sort_by' => $column, 'sort_direction' => $dir]);

                                            $icon = $column == $sortBy ? ($dir == 'asc' ? '<i class="fas fa-arrow-up fa-xs ms-1"></i>' : '<i class="fas fa-arrow-down fa-xs ms-1"></i>') : '';

                                            return '<a class="text-decoration-none text-dark fw-semibold" href="' . route('admin.users.index', $query) . '">' . $label . ' ' . $icon . '</a>';

                                        };

                                    @endphp

                                    @foreach($sortableColumns as $column => $label)

                                        <th>{!! $sort($column, $label) !!}</th>

                                    @endforeach

                                    <th class="text-center" style="width: 200px;">Actions</th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($users as  $index =>$user)

                                    <tr>

                                        <td>{{ $users->firstItem() + $index }}</td>

                                        <td>



                                            {{ $user->name }}



                                        </td>

                                        <td>{{ $user->email }}</td>

                                        <td>{{ $user->created_at->format('Y-m-d') }}</td>

                                        <td class="text-center">

                                            <div class="btn-group">

                                                <a href="{{ route('admin.users.show', $user) }}"
                                                    class="btn btn-sm btn-primary me-2" data-toggle="tooltip" title="View">

                                                    <i class="bi bi-eye"></i>

                                                </a>

                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                    class="btn btn-sm btn-info me-2" data-toggle="tooltip" title="Edit">

                                                    <i class="bi bi-pencil"></i>

                                                </a>

                                                @if($user->id !== 1)
                                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                        class="d-inline" id="delete-form-{{ $user->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            data-toggle="tooltip" title="Delete"
                                                            onclick="return confirm('This action cannot be undone. Delete this User?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>

                                                    </form>
                                                @endif

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="5" class="text-center">No users found.</td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>



                <div class="card-footer clearfix">

                    <div class="float-right">

                        {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>