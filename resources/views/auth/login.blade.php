<x-guest-layout>


    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('E-mail') }}" />
                <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox class="checkbox-licenciamento" id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="block mt-2" style="align-content: center; text-align: center;">
                <button type="submit" class="submeterFormBotao btn btn-success btn-color-dafault" style="margin-left: 15px; width: 40%;">
                    {{ __('Entrar') }}
                </button>
            </div>

            <div class="block mt-2" style="align-content: center; text-align: center;">
                <span class="text-sm text-gray-600" style="font-size: 16px;">
                    {{ __('Ou') }}
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" style="font-size: 16px;" href="{{ route('register') }}">
                        {{ __('cadastre-se') }}
                    </a>
                </span>
            </div>

            <div class="block mt-2" style="align-content: center; text-align: center;">
                @if (Route::has('password.request'))
                    <span class="text-sm text-gray-600">
                        {{ __('Forgot your password?') }}
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('clique aqui') }}
                        </a>
                    </span>
                @endif
            </div>

            {{-- <div class="flex items-center justify-end mt-4">

            </div> --}}
        </form>
    </x-authentication-card>


</x-guest-layout>
