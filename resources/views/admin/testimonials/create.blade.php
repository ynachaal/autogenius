<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Add New Testimonial') }}
        </h2>
    </x-slot>

    @include('admin.testimonials._form', [
        'action' => route('admin.testimonials.store'),
        'formId' => 'createTestimonialForm',
        'submitButtonText' => __('Create Testimonial'),
        'includeValidation' => true
    ])
</x-app-layout>