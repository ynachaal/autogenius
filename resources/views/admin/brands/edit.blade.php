<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">{{ __('Edit Brand') }}</h2>
    </x-slot>

    @include('admin.brands._form', [
        'action' => route('admin.brands.update', $brand),
        'method' => method_field('PUT'),
        'name' => old('name', $brand->name),
        'description' => old('description', $brand->description),
        'status' => old('status', $brand->status),
        'is_featured' => old('is_featured', $brand->is_featured),
        'order' => old('order', $brand->order),
        'meta_title' => old('meta_title', $brand->meta_title),
        'meta_description' => old('meta_description', $brand->meta_description),
        'meta_keywords' => old('meta_keywords', $brand->meta_keywords),
        'submitButtonText' => __('Update Brand'),
        'required' => 'required',
        'includeValidation' => false
    ])
</x-app-layout>
