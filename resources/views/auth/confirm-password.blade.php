<x-guest-layout>
    @component('layouts.nav_bar')@endcomponent
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" autofocus />
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </x-jet-authentication-card>
    @component('layouts.footer')@endcomponent
</x-guest-layout>
