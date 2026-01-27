<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Create Slide') }}
        </h2>
    </x-slot>

    @include('admin.sliders._form', [
        'action' => route('admin.sliders.store'),
        'formId' => 'createSliderForm',
        'submitButtonText' => __('Create Slider'),
        'includeValidation' => true
    ])
</x-app-layout>