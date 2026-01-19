<x-app-layout>

    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Create Service') }}
        </h2>
    </x-slot>

    @include('admin.services._form', [
        'action' => route('admin.services.store'),
        'formId' => 'createServiceForm',
        'submitButtonText' => __('Create Service'),
        'includeValidation' => true
    ])

</x-app-layout>
