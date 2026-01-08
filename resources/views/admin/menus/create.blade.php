<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Create Menu') }}
        </h2>
    </x-slot>

    @include('admin.menus._form', [
        'action' => route('admin.menus.store'),
        'formId' => 'createMenuForm',
        'submitButtonText' => __('Create Menu'),
        'pages' => $pages,
        'posts' => $posts,
        'menus' => $menus,
        'categories' => $categories,
        'includeValidation' => true
    ])
</x-app-layout>