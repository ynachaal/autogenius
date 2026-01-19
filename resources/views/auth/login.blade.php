<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

   @push('scripts')
<script>
    $(document).ready(function () {
        $('#loginForm').validate({
            // Define rules
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                }
            },
            
            // Define the element and the class applied to it
            errorElement: 'span',
            
            // FIX: Use a simple class name here if the complex one fails, 
            // or ensure it is wrapped correctly.
            errorClass: 'validation-error', 
            
            // Use the 'errorPlacement' function to apply Tailwind classes dynamically
            errorPlacement: function(error, element) {
                error.addClass('text-sm text-red-600 dark:text-red-400 mt-2 block');
                error.insertAfter(element);
            },
            
            highlight: function (element) {
                $(element).addClass('border-red-500 focus:border-red-500 focus:ring-red-500')
                          .removeClass('border-gray-300 dark:border-gray-700');
            },
            unhighlight: function (element) {
                $(element).removeClass('border-red-500 focus:border-red-500 focus:ring-red-500')
                          .addClass('border-gray-300 dark:border-gray-700');
            }
        });
    });
</script>
@endpush
</x-guest-layout>