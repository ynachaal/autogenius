<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-medium mb-0 text-dark">
            {{ __('Create Email Template') }}
        </h2>
    </x-slot>

    @include('admin.email-templates._form', [
        'action' => route('admin.email-templates.store'),
        'formId' => 'email-template-form',
        'header' => __('Create Email Template'),
        'submitButtonText' => __('Create Template'),
        'publishLabel' => __('Publish Immediately')
    ])
</x-app-layout>
