<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Edit Page') }}</h2>
    </x-slot>

    @include('admin.pages._form', [
        'action' => route('admin.pages.update', $page),
        'method' => method_field('PUT'),
        
        // Existing Fields
        'title' => old('title', $page->title),
        'slug' => old('slug', $page->slug),
        'content' => old('content', $page->content),
        'sub_content' => old('sub_content', $page->sub_content),
        'is_published' => old('is_published', $page->is_published),
        
        // === NEW SEO FIELDS (For existing data) ===
        'meta_title' => old('meta_title', $page->meta_title),
        'meta_description' => old('meta_description', $page->meta_description),
        'meta_keywords' => old('meta_keywords', $page->meta_keywords),
        // ===========================================

        'submitButtonText' => __('Update Page'),
        'required' => 'required',
       
    ])
</x-app-layout>