<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Create Service Fee') }}
        </h2>
    </x-slot>

    @include('admin.service-fees._form', [
        'action' => route('admin.service-fees.store'),
        'formId' => 'createServiceFeeForm',
        'submitButtonText' => __('Create Fee'),
        'includeValidation' => true
    ])
</x-app-layout>