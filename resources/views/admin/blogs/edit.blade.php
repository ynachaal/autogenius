<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Edit Blog') }}
        </h2>
    </x-slot>

    @include('admin.blogs._form', [
        'action' => route('admin.blogs.update', $blog),
        'method' => method_field('PUT'),
        'header' => __('Update Post Details'),
        'title' => old('title', $blog->title),
        'category_id' => old('category_id', $blog->category_id),
        'content' => old('content', $blog->content),
        'is_published' => old('is_published', $blog->is_published),
        'submitButtonText' => __('Update Post'),
        'publishLabel' => __('Published'),
        'required' => 'required',
        'categories' => $categories
    ])
</x-app-layout>