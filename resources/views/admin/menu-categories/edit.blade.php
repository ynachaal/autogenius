<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Edit Menu Category') }}
        </h2>
    </x-slot>

    @include('admin.menu-categories._form', [
        'action' => route('admin.menu-categories.update', $menuCategory),
        'method' => method_field('PUT'),
        'name' => old('name', $menuCategory->name),
        'description' => old('description', $menuCategory->description),
        'submitButtonText' => __('Update Category'),
        'includeValidation' => false
    ])
</x-app-layout>