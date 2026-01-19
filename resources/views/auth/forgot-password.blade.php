<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>

    @push('scripts')
    <script>
        $(document).ready(function () {
            $('#forgotPasswordForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter a valid email address."
                    }
                },
                errorElement: 'span',
                errorClass: 'jquery-validation-error', 
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