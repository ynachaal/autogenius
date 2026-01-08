<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">{{ __('Application Settings') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">

                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        @method('PUT')

                        <h5 class="mb-4 border-bottom pb-2">General Website Configuration</h5>

                        @php
                            $defaultSettings = [
                                'site_name' => '',
                                'tagline' => '',
                                'admin_email' => '',
                            ];
                            $settingKeys = array_keys(array_merge($defaultSettings, $settings->toArray()));
                        @endphp

                        <div class="mb-3">
                            @foreach ($settingKeys as $key)
                                @php
                                    $currentValue = $settings->get($key)?->value ?? ($defaultSettings[$key] ?? '');
                                    $label = str_replace('_', ' ', Str::title($key));
                                @endphp

                                <div class="mb-3">
                                    <label for="{{ $key }}" class="form-label">{{ $label }}</label>

                                    @if (Str::length($currentValue) > 50)
                                        <textarea id="{{ $key }}" name="settings[{{ $key }}]" rows="3"
                                                  class="form-control">{{ old('settings.' . $key, $currentValue) }}</textarea>
                                    @else
                                        <input id="{{ $key }}" name="settings[{{ $key }}]" type="text"
                                               value="{{ old('settings.' . $key, $currentValue) }}"
                                               class="form-control" />
                                    @endif

                                    <x-input-error :messages="$errors->get('settings.' . $key)" class="form-text text-danger mt-1" />
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
