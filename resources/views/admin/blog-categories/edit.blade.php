<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    @include('admin.blog-categories._form', [
        'action' => route('admin.blog-categories.update', $blogCategory),
        'method' => method_field('PUT'),
        'name' => old('name', $blogCategory->name),
        'description' => old('description', $blogCategory->description),
        'submitButtonText' => __('Update Category'),
        'required' => 'required',
        'includeValidation' => false
    ])
</x-app-layout>