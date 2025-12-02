<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    @include('admin.users._form', [
        'action' => route('admin.users.update', $user),
        'method' => method_field('PUT'),
        'header' => __('Update User Details'),
        'name' => old('name', $user->name),
        'email' => old('email', $user->email),
        'submitButtonText' => __('Update User'),
        'passwordLabel' => __('Password (leave blank to keep unchanged)'),
        'passwordRequired' => false,
        'passwordConfirmationRequired' => false,
        'required' => 'required'
    ])
</x-app-layout>