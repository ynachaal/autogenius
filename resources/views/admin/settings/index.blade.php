<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-medium mb-0 text-dark">{{ __('Application Settings') }}</h2>
    </x-slot>

    <div class="card card-primary card-outline">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data"
                id="adminSettingForm">
                @csrf
                @method('PUT')

                @php
                    $defaultSettings = [
                        // General
                        'site_name' => '',
                        'tagline' => '',
                        'admin_email' => '',
                        'footer_text' => '',
                        'home_page_banner_title' => '',
                        'home_page_banner_text' => '',
                        // Meta
                        'meta_title' => '',
                        'meta_description' => '',
                        'meta_keywords' => '',
                        // Social
                        'facebook_url' => '',
                        'twitter_url' => '',
                        'instagram_url' => '',
                        'linkedin_url' => '',
                        'youtube_url' => '',
                        'tiktok_url' => '',
                        // Contact
                        'phone' => '',
                        'address' => '',
                        'map_embed' => '',
                        'contact_email' => '',
                        'site_ceo_image' => '',
                        'site_ceo_message' => '',
                        // Footer
                        'footer_about' => '',
                    ];
                @endphp

                {{-- Tabs --}}
                <ul class="nav nav-tabs mb-3" id="settingsTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                            type="button" role="tab">General</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="meta-tab" data-bs-toggle="tab" data-bs-target="#meta"
                            type="button" role="tab">Meta</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social"
                            type="button" role="tab">Social</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                            type="button" role="tab">Contact</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ceo-tab" data-bs-toggle="tab" data-bs-target="#ceo"
                            type="button" role="tab">CEO Message</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="footer-tab" data-bs-toggle="tab" data-bs-target="#footer"
                            type="button" role="tab">Footer</button>
                    </li>

                </ul>

                <div class="tab-content">

                    {{-- GENERAL --}}
                    <div class="tab-pane fade show active" id="general">
                        @php $generalKeys = ['site_name','tagline','admin_email','footer_text','home_page_banner_title','home_page_banner_text']; @endphp
                        <div class="row">
                            @foreach ($generalKeys as $key)
                                @php $val = $settings->get($key)?->value ?? $defaultSettings[$key]; @endphp
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ Str::title(str_replace('_', ' ', $key)) }}</label>
                                    <input type="text" name="settings[{{ $key }}]"
                                        value="{{ old('settings.' . $key, $val) }}" class="form-control">
                                    <x-input-error :messages="$errors->get('settings.' . $key)" class="text-danger mt-1" />
                                </div>
                            @endforeach
                        </div>

                        {{-- Site Logo --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Site Logo</label>
                                <input type="file" name="site_logo" class="form-control" accept="image/*">
                                <x-input-error :messages="$errors->get('site_logo')" class="text-danger mt-1" />
                                @if ($settings->get('site_logo'))
                                    <img src="{{ asset($settings->get('site_logo')->value) }}" class="mt-2"
                                        style="max-width:200px">
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- META --}}
                    <div class="tab-pane fade" id="meta">
                        @php $metaKeys = ['meta_title','meta_description','meta_keywords']; @endphp
                        <div class="row">
                            @foreach ($metaKeys as $key)
                                @php $val = $settings->get($key)?->value ?? $defaultSettings[$key]; @endphp
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ Str::title(str_replace('_', ' ', $key)) }}</label>
                                    @if (Str::contains($key, ['description', 'keywords']))
                                        <textarea name="settings[{{ $key }}]" class="form-control" rows="3">{{ old('settings.' . $key, $val) }}</textarea>
                                    @else
                                        <input type="text" name="settings[{{ $key }}]"
                                            value="{{ old('settings.' . $key, $val) }}" class="form-control">
                                    @endif
                                    <x-input-error :messages="$errors->get('settings.' . $key)" class="text-danger mt-1" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- SOCIAL --}}
                    <div class="tab-pane fade" id="social">
                        @php $socialKeys = ['facebook_url','twitter_url','instagram_url','linkedin_url','youtube_url','tiktok_url']; @endphp
                        <div class="row">
                            @foreach ($socialKeys as $key)
                                @php $val = $settings->get($key)?->value ?? $defaultSettings[$key]; @endphp
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ Str::title(str_replace('_', ' ', $key)) }}</label>
                                    <input type="url" name="settings[{{ $key }}]"
                                        value="{{ old('settings.' . $key, $val) }}" class="form-control">
                                    <x-input-error :messages="$errors->get('settings.' . $key)" class="text-danger mt-1" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- CONTACT --}}
                    <div class="tab-pane fade" id="contact">
                        @php $contactKeys = ['phone','contact_email','address','map_embed']; @endphp
                        <div class="row">
                            @foreach ($contactKeys as $key)
                                @php $val = $settings->get($key)?->value ?? $defaultSettings[$key]; @endphp
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ Str::title(str_replace('_', ' ', $key)) }}</label>
                                    @if ($key === 'map_embed')
                                        <textarea name="settings[{{ $key }}]" class="form-control" rows="3">{{ old('settings.' . $key, $val) }}</textarea>
                                    @else
                                        <input type="text" name="settings[{{ $key }}]"
                                            value="{{ old('settings.' . $key, $val) }}" class="form-control">
                                        @if ($key === 'phone')
                                            <small class="text-muted">Only numbers, spaces, and + are allowed.</small>
                                        @endif
                                    @endif
                                    <x-input-error :messages="$errors->get('settings.' . $key)" class="text-danger mt-1" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- CEO Message --}}
                    <div class="tab-pane fade" id="ceo">

                        {{-- CEO Image --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CEO Image</label>
                                <input type="file" name="site_ceo_image" class="form-control" accept="image/*">
                                <x-input-error :messages="$errors->get('site_ceo_image')" class="text-danger mt-1" />
                                @if ($settings->get('site_ceo_image'))
                                    <img src="{{ asset($settings->get('site_ceo_image')->value) }}" class="mt-2"
                                        style="max-width:200px">
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">CEO Message</label>
                                <textarea name="settings[site_ceo_message]" id="editor" rows="2" class="form-control tinymce-editor">{{ $settings->get('site_ceo_message')?->value }}</textarea>
                                <x-input-error :messages="$errors->get('settings.site_ceo_message')" class="text-danger mt-1" />
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <div class="tab-pane fade" id="footer">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Footer About</label>
                                <textarea name="settings[footer_about]" class="form-control" rows="3">{{ old('settings.footer_about', $settings->get('footer_about')?->value ?? '') }}</textarea>
                                <x-input-error :messages="$errors->get('settings.footer_about')" class="text-danger mt-1" />
                            </div>
                        </div>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.querySelector('input[name="settings[phone]"]');
            if (phoneInput) {
                phoneInput.addEventListener('input', function() {
                    this.value = this.value.replace(/[^\d+]/g, '');
                });
            }
        });
    </script>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $.validator.addMethod("phoneCharsOnly", function(value, element) {
                    // Returns true if the value contains ONLY digits, spaces, or plus signs
                    return this.optional(element) || /^[\d+]+$/.test(value);
                }, "Only numbers and the + symbol are allowed.");
                if (typeof $.fn.validate !== 'undefined') {
                    $("#adminSettingForm").validate({
                        ignore: [],
                        rules: {
                            "settings[phone]": {
                                required: true,
                                maxlength: 15,
                                phoneCharsOnly: true // Use our custom method here
                            },


                        },
                        messages: {
                            "settings[phone]": "Only numbers and the + symbol are allowed",
                        },
                        errorElement: 'div',
                        errorClass: 'invalid-feedback',
                        highlight: function(element) {
                            $(element).addClass('is-invalid');
                        },
                        unhighlight: function(element) {
                            $(element).removeClass('is-invalid');
                        },
                        errorPlacement: function(error, element) {
                            error.insertAfter(element);
                        },
                        invalidHandler: function(event, validator) {
                            // OPTIONAL: This part automatically switches to the tab with the error
                            if (validator.errorList.length > 0) {
                                var firstErrorElement = $(validator.errorList[0].element);
                                var tabPane = firstErrorElement.closest('.tab-pane');
                                var tabId = tabPane.attr('id');

                                // Activate the tab containing the first error
                                var tabTrigger = $('button[data-bs-target="#' + tabId + '"]');
                                if (tabTrigger.length > 0) {
                                    var tab = new bootstrap.Tab(tabTrigger[0]);
                                    tab.show();
                                }
                            }
                        },
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
