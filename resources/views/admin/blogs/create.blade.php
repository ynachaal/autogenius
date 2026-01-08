<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Create New Blog Post') }}
        </h2>
    </x-slot>

    @include('admin.blogs._form', [
        'action' => route('admin.blogs.store'),
        'formId' => 'blog-form',
        'header' => __('Post Details'),
        'submitButtonText' => __('Save Post'),
        'publishLabel' => __('Publish Immediately'),
        'categories' => $categories
    ])
</x-app-layout>