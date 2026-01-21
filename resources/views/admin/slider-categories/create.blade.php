<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Create Slider Category') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            @include('admin.slider-categories._form', [
                'action' => route('admin.slider-categories.store'),
                'formId' => 'createSliderCategoryForm',
                'submitButtonText' => __('Create Category'),
                'includeValidation' => true
            ])
        </div>
    </div>
</x-app-layout>