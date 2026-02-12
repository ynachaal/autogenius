<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Edit Testimonial: :title', ['title' => $testimonial->title]) }}
        </h2>
    </x-slot>

    @include('admin.testimonials._form', [
        'action' => route('admin.testimonials.update', $testimonial),
        'method' => method_field('PUT'),
        'title' => old('title', $testimonial->title),
        'description' => old('description', $testimonial->description),
        'youtube_url' => old('youtube_url', $testimonial->youtube_url),
        'designation' => old('designation', $testimonial->designation), // Add this line
        'order' => old('order', $testimonial->order),
        'status' => old('status', $testimonial->status),
        'submitButtonText' => __('Update Testimonial'),
        'includeValidation' => true
    ])
</x-app-layout>