<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">
            {{ __('Edit FAQ') }}
        </h2>
    </x-slot>

    @include('admin.faqs._form', [
        'action' => route('admin.faqs.update', $faq),
        'method' => method_field('PUT'),
        'header' => __('Update Frequently Asked Question'),
        'question' => old('question', $faq->question),
        'answer' => old('answer', $faq->answer),
        'order' => old('order', $faq->order),
        'is_active' => old('is_active', $faq->is_active),
        'submitButtonText' => __('Update FAQ'),
        'required' => 'required'
    ])
</x-app-layout>