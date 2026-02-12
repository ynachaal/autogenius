<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Testimonials') }}</h2>
    </x-slot>

    <div class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Testimonial Management</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Add New
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width: 50px">Order</th>
                                <th>Author/Title</th>
                                <th>Content</th>
                                <th>Video</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $testimonial)
                                <tr>
                                    <td>{{ $testimonial->order }}</td>
                                    <td><strong>{{ $testimonial->title }}</strong></td>
                                    <td>{{ Str::limit(strip_tags($testimonial->description), 50) }}</td>
                                    <td>
                                        @if($testimonial->youtube_url)
                                            <span class="badge bg-danger"><i class="fab fa-youtube"></i> Video</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $testimonial->status ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $testimonial->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-info me-1">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Delete this testimonial?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center p-4">No testimonials found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>