<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">
            {{ __('Create New FAQ') }}
        </h2>
    </x-slot>

    @include('admin.faqs._form', [
        'action' => route('admin.faqs.store'),
        'formId' => 'faq-form',
        'header' => __('New Frequently Asked Question'),
        'submitButtonText' => __('Save FAQ'),
        'nextOrder' => $nextOrder ?? 1
    ])
</x-app-layout>