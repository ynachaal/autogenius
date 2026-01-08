<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark mb-0">
            {{ __('Edit Menu') }}
        </h2>
    </x-slot>

    @include('admin.menus._form', [
        'action' => route('admin.menus.update', $menu),
        'method' => method_field('PUT'),
        'title' => old('title', $menu->title),
        'external_link' => old('external_link', $menu->external_link),
        'page_id' => old('page_id', $menu->page_id),
        'post_id' => old('post_id', $menu->post_id),
        'parent_id' => old('parent_id', $menu->parent_id),
        'order' => old('order', $menu->order),
        'is_active' => old('is_active', $menu->is_active),
        'submitButtonText' => __('Update Menu'),
        'pages' => $pages,
        'posts' => $posts,
        'menus' => $menus,
        'includeValidation' => false
    ])
</x-app-layout>