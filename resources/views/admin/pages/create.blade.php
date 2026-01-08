<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Create New Page') }}</h2>
    </x-slot>

    @include('admin.pages._form', [
        'action' => route('admin.pages.store'),
        'formId' => 'page-form',
        'submitButtonText' => __('Create Page')
    ])
</x-app-layout>