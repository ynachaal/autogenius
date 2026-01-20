<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-medium mb-0 text-dark">
            {{ __('Edit Email Template') }}
        </h2>
    </x-slot>

    @include('admin.email-templates._form', [
        'action' => route('admin.email-templates.update', $emailTemplate),
        'method' => method_field('PUT'),
        'title' => old('title', $emailTemplate->title),
        'subject' => old('subject', $emailTemplate->subject),
        'content' => old('content', $emailTemplate->content),
        'is_published' => old('is_published', $emailTemplate->is_published),
        'emailTemplate' => $emailTemplate,
        'header' => __('Edit Email Template'),
        'submitButtonText' => __('Update Template'),
        'publishLabel' => __('Publish Immediately')
    ])
</x-app-layout>
