<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Create Blog Category') }}
        </h2>
    </x-slot>

    @include('admin.blog-categories._form', [
        'action' => route('admin.blog-categories.store'),
        'formId' => 'createCategoryForm',
        'submitButtonText' => __('Create Category'),
        'includeValidation' => true
    ])
</x-app-layout>