<x-guest-layout>
    <div id="body">
        <div class="container-login">
            <div class="card-login">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <h1 class="justify-center" id="h1-auth">Registrar</h1>
        <div class="label-float">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="label-float">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="label-float">
            <x-input-label id="labelSenha" for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="label-float">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div >
            <a id="forgot" href="{{ route('login') }}">
                {{ __('Já tem uma conta? Entrar') }}
            </a>

            <div class="justify-center">
                <x-primary-button id="button-login">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </div>
    </form>
    </div>
    </div>
    </div>
</x-guest-layout>
