<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">{{ __('Create Brand') }}</h2>
    </x-slot>

    @include('admin.brands._form', [
        'action' => route('admin.brands.store'),
        'formId' => 'createBrandForm',
        'submitButtonText' => __('Create Brand'),
        'includeValidation' => true
    ])
</x-app-layout>
