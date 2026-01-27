<x-app-layout>

    <x-slot name="header">

        <h2 class="h4">{{ __('Pages') }}</h2>

    </x-slot>



    <div class="content"> {{-- AdminLTE content wrapper class --}}

        <div class="container-fluid"> {{-- AdminLTE container for fluid layout --}}

            <div class="card card-primary card-outline"> {{-- AdminLTE Card styling --}}



                {{-- AdminLTE: Card Header for Title, Search, and Create Button --}}

                <div class="card-header">

                    <h3 class="card-title">Page List</h3>



                    {{-- AdminLTE Card Tools (for search and create button) --}}

                    <div class="card-tools d-flex align-items-center">

                        {{-- Search Form with Clear Button --}}

                        <form action="{{ route('admin.pages.index') }}" method="GET" class="d-flex align-items-center me-2">

                            <div class="input-group input-group-sm" style="width: 250px;">

                                <input type="search" name="q" class="form-control float-right"

                                    placeholder="Search by title or slug..." value="{{ request('q') }}">

                                <div class="input-group-append">

                                    <button class="btn btn-default" type="submit" title="Search">

                                        <i class="fas fa-search"></i> {{-- Font Awesome Search Icon --}}
                                        Search
                                    </button>

                                    {{-- Clear Button: Only show if search query exists --}}

                                    @if(request('q'))

                                        <a href="{{ route('admin.pages.index', array_merge(request()->except(['q', 'page']), ['q' => ''])) }}"

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

                        <a href="{{ route('admin.pages.create') }}" class="btn btn-sm btn-success" title="Create Page">

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

                                            'title' => 'Title',

                                            'slug' => 'Slug',

                                            'is_published' => 'Published',

                                            'created_at' => 'Created'

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

                                            return '<a class="text-decoration-none text-dark fw-semibold" href="' . route('admin.pages.index', $query) . '">' . $label . ' ' . $icon . '</a>';

                                        };

                                    @endphp

                                    @foreach($sortableColumns as $column => $label)

                                        <th class="{{ $column == 'is_published' ? 'text-center' : '' }}">{!! $sort($column, $label) !!}</th>

                                    @endforeach

                                    <th class="text-center" style="width: 150px;">Actions</th> {{-- Fixed width for actions --}}

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($pages as $index=>$page)

                                    <tr>

                                           <td>{{ $pages->firstItem() + $index }}</td>

                                        <td>
                                                {{ Str::limit($page->title, 40) }}

                                        </td>

                                        <td>{{ $page->slug }}</td>

                                        <td class="text-center">

                                            @if($page->is_published)

                                                <span class="badge bg-success">Yes</span>

                                            @else

                                                <span class="badge bg-warning">No</span> {{-- AdminLTE badge classes --}}

                                            @endif

                                        </td>

                                        <td>{{ $page->created_at->format('Y-m-d') }}</td>

                                        <td class="text-center">

                                            <div class="btn-group" role="group" aria-label="Page Actions">

                                                  <a href="{{ route('admin.pages.show', $page) }}"

                                                    class="btn btn-sm btn-primary me-2" data-toggle="tooltip" title="View">

                                                    <i class="bi bi-eye"></i>

                                                </a>

                                                <a href="{{ route('admin.pages.edit', $page) }}"

                                                    class="btn btn-sm btn-info me-2" data-toggle="tooltip" title="Edit">

                                                    <i class="bi bi-pencil"></i>

                                                </a>

                                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"

                                                    class="d-inline" id="delete-form-{{ $page->id }}">

                                                    @csrf

                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this page?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="6" class="text-center">No pages found.</td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>



                {{-- AdminLTE: Card Footer for Pagination --}}

                <div class="card-footer clearfix">

                    <div class="float-right">

                        {{ $pages->appends(request()->query())->links('pagination::bootstrap-5') }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>