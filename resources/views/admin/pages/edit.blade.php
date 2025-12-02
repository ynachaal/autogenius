<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Edit Page') }}</h2>
    </x-slot>

    @include('admin.pages._form', [
        'action' => route('admin.pages.update', $page),
        'method' => method_field('PUT'),
        'title' => old('title', $page->title),
        'slug' => old('slug', $page->slug),
        'content' => old('content', $page->content),
        'is_published' => old('is_published', $page->is_published),
        'submitButtonText' => __('Update Page'),
        'required' => 'required'
    ])
</x-app-layout>