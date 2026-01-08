<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('FAQ: :question', ['question' => Str::limit($faq->question, 60)]) }}
        </h2>
    </x-slot>

    <div class="content py-4">
        <div class="container-fluid">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">FAQ Details</h3>
                    <div class="card-tools d-flex gap-2">
                        <a href="{{ route('admin.faqs.edit', $faq) }}"
                           class="btn btn-sm btn-primary"
                           data-toggle="tooltip"
                           title="Edit FAQ">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.faqs.destroy', $faq) }}"
                              method="POST"
                              class="d-inline"
                              id="delete-form-{{ $faq->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-danger"
                                    data-toggle="tooltip"
                                    title="Delete FAQ"
                                    onclick="return showConfirmationModal('delete-form-{{ $faq->id }}', '{{ Str::limit($faq->question, 60) }}', 'FAQ')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>
                        <a href="{{ route('admin.faqs.index') }}"
                           class="btn btn-sm btn-secondary"
                           data-toggle="tooltip"
                           title="Back to List">
                            <i class="bi bi-list me-1"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-2">
                                <strong>Question (Order {{ $faq->order }}):</strong>
                                <span class="fw-semibold">{{ $faq->question }}</span>
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Status:</strong>
                                @if($faq->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Created at:</strong> {{ $faq->created_at->format('M d, Y H:i A') }}
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Updated at:</strong> {{ $faq->updated_at->format('M d, Y H:i A') }}
                            </p>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div>
                        <strong>Answer:</strong>
                        <div class="border p-3 rounded bg-light">{!! nl2br(e($faq->answer)) !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>