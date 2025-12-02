<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Create Menu Category') }}
        </h2>
    </x-slot>

    @include('admin.menu_categories._form', [
        'action' => route('admin.menu_categories.store'),
        'formId' => 'createMenuCategoryForm',
        'submitButtonText' => __('Create Category'),
        'includeValidation' => true
    ])
</x-app-layout>