<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Edit Service Fee') }}
        </h2>
    </x-slot>

    @include('admin.service-fees._form', [
        'action' => route('admin.service-fees.update', $serviceFee),
        'method' => method_field('PUT'),
        'serviceFee' => $serviceFee,
        'submitButtonText' => __('Update Fee'),
        'includeValidation' => true
    ])
</x-app-layout>