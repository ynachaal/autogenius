<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Edit Slide') }}
        </h2>
    </x-slot>

    @include('admin.sliders._form', [
        'action' => route('admin.sliders.update', $slider),
        'method' => method_field('PUT'),
        'slider' => $slider, // Pass the model for old values
        'submitButtonText' => __('Update Slider'),
        'includeValidation' => false
    ])
</x-app-layout>