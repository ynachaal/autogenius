<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Create New User') }}
        </h2>
    </x-slot>

    @include('admin.users._form', [
        'action' => route('admin.users.store'),
        'formId' => 'user-form',
        'header' => __('User Details'),
        'submitButtonText' => __('Save User'),
        'passwordRequired' => true,
        'passwordConfirmationRequired' => true
    ])
</x-app-layout>