<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Edit Slider Category: :name', ['name' => $sliderCategory->name]) }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            @include('admin.slider-categories._form', [
                'action' => route('admin.slider-categories.update', $sliderCategory),
                'method' => method_field('PUT'),
                'sliderCategory' => $sliderCategory,
                'submitButtonText' => __('Update Category'),
                'includeValidation' => true
            ])
        </div>
    </div>
</x-app-layout>