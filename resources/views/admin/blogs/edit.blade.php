<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-medium mb-0 text-dark">
            {{ __('Edit Blog') }}
        </h2>
    </x-slot>

    @include('admin.blogs._form', [
        'action' => route('admin.blogs.update', $blog),
        'method' => method_field('PUT'),
        'title' => old('title', $blog->title),
        'slug' => old('slug', $blog->slug),
        'content' => old('content', $blog->content),
        'author_id' => old('author_id', $blog->author_id),
        'category_id' => old('category_id', $blog->category_id),
        'is_published' => old('is_published', $blog->is_published),
        'blog' => $blog,
        'categories' => $categories,
        'users' => $users,
        'header' => __('Edit Post'),
        'submitButtonText' => __('Update Post'),
        'publishLabel' => __('Publish Immediately'),
        'required' => 'required',
        'meta_title' => old('meta_title', $blog->meta_title),
        'meta_keywords' => old('meta_keywords', $blog->meta_keywords),
        'meta_description' => old('meta_description', $blog->meta_description),
    ])
</x-app-layout>
