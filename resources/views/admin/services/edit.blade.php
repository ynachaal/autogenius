<x-app-layout>

    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Edit Service') }}
        </h2>
    </x-slot>

    @include('admin.services._form', [
        'action' => route('admin.services.update', $service),
        'method' => method_field('PUT'),
        'title' => old('title', $service->title),
        'slug' => old('slug', $service->slug), 
        'sub_heading' => old('sub_heading', $service->sub_heading),
        'description' => old('description', $service->description),
        'image' => $service->image,

        // ✅ ADD THIS
        'youtube_url' => old('youtube_url', $service->youtube_url),

        /* SEO Meta Fields */
        'meta_title' => old('meta_title', $service->meta_title),
        'meta_description' => old('meta_description', $service->meta_description),
        'meta_keywords' => old('meta_keywords', $service->meta_keywords),

        'status' => old('status', $service->status),
        'featured' => old('featured', $service->featured),
        'submitButtonText' => __('Update Service'),
        'includeValidation' => true 
    ])

</x-app-layout>
