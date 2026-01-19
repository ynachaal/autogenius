<x-app-layout>

    <x-slot name="header">

        <h2 class="h4">{{ __('Faqs') }}</h2>

    </x-slot>



    <div class="content"> {{-- AdminLTE content wrapper class --}}

        <div class="container-fluid"> {{-- AdminLTE container for fluid layout --}}

            <div class="card card-primary card-outline"> {{-- AdminLTE Card styling --}}



                {{-- AdminLTE: Card Header for Title, Search, and Create Button --}}

                <div class="card-header">

                    <h3 class="card-title">Faq List</h3>



                    {{-- AdminLTE Card Tools (for search and create button) --}}

                    <div class="card-tools d-flex align-items-center">

                        {{-- Search Form with Clear Button --}}

                        <form action="{{ route('admin.faqs.index') }}" method="GET" class="d-flex align-items-center me-2">

                            <div class="input-group input-group-sm" style="width: 250px;">

                                <input type="search" name="q" class="form-control float-right"

                                    placeholder="Search by question or answer..." value="{{ request('q') }}">

                                <div class="input-group-append">

                                    <button class="btn btn-default" type="submit" title="Search">

                                        <i class="fas fa-search"></i> {{-- Font Awesome Search Icon --}}
                                        Search

                                    </button>

                                    {{-- Clear Button: Only show if search query exists --}}

                                    @if(request('q'))

                                        <a href="{{ route('admin.faqs.index', array_merge(request()->except(['q', 'page']), ['q' => ''])) }}"

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

                        <a href="{{ route('admin.faqs.create') }}" class="btn btn-sm btn-success" title="Create FAQ">

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

                                            'question' => 'Question',

                                            'order' => 'Order',

                                            'is_active' => 'Active',

                                            'created_at' => 'Created At'

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

                                            return '<a class="text-decoration-none text-dark fw-semibold" href="' . route('admin.faqs.index', $query) . '">' . $label . ' ' . $icon . '</a>';

                                        };

                                    @endphp

                                    @foreach($sortableColumns as $column => $label)

                                        <th>{!! $sort($column, $label) !!}</th>

                                    @endforeach

                                    <th class="text-center" style="width: 150px;">Actions</th> {{-- Fixed width for actions --}}

                                </tr>

                            </thead>

                            <tbody>

                                   @forelse($faqs as $index=>$faq)

                                    <tr>

                                       <td>{{ $faqs->firstItem() + $index }}</td>

                                        <td>

                                          

                                                {{ Str::limit($faq->question, 60) }}

                                         

                                        </td>

                                        <td>{{ $faq->order }}</td>

                                        <td>

                                            @if($faq->is_active)

                                                <span class="badge bg-success">Yes</span>

                                            @else

                                                <span class="badge bg-warning">No</span> {{-- AdminLTE badge classes --}}

                                            @endif

                                        </td>

                                        <td>{{ $faq->created_at->format('Y-m-d') }}</td>

                                        <td class="text-center">

                                            <div class="btn-group" role="group" aria-label="FAQ Actions">

                                                 <a href="{{ route('admin.faqs.show', $faq) }}"

                                                    class="btn btn-sm btn-primary me-2" data-toggle="tooltip" title="View">

                                                    <i class="bi bi-eye"></i>

                                                </a>

                                                <a href="{{ route('admin.faqs.edit', $faq) }}"

                                                    class="btn btn-sm btn-info me-2" data-toggle="tooltip" title="Edit">

                                                    <i class="bi bi-pencil"></i>

                                                </a>

                                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST"

                                                    class="d-inline" id="delete-form-{{ $faq->id }}">

                                                    @csrf

                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger"

                                                        data-toggle="tooltip" title="Delete"

                                                        onclick="return showConfirmationModal('delete-form-{{ $faq->id }}', '{{ Str::limit($faq->question, 60) }}', 'FAQ')">

                                                        <i class="bi bi-trash"></i>

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="6" class="text-center">No FAQs found.</td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>



                {{-- AdminLTE: Card Footer for Pagination --}}

                <div class="card-footer clearfix">

                    <div class="float-right">

                        {{ $faqs->appends(request()->query())->links('pagination::bootstrap-5') }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>