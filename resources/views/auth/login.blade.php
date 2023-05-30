<x-guest-layout>
    <x-auth-session-status :status="session('status')" />

        <div id="body">
            <div class="container-login">
                <div class="card-login">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h1>Entrar</h1>

                        <div class="label-float">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="label-float">
                            <x-input-label id="labelSenha" for="password" :value="__('Senha')" />

                            <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>


                        <div class="">
                            <label id="remember-label" for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" name="remember">
                                <span id="span" class="">{{ __('Lembrar de mim') }}</span>
                            </label>
                            <br>
                        </div>

                        <div>
                            @if (Route::has('password.request'))
                                <a id="forgot" href="{{ route('password.request') }}">
                                    {{ __('Esqueceu sua senha?') }}
                                </a>
                            @endif

                            <div>
                                <a id="forgot" href="/register">
                                    Não tem uma conta? Registrar
                                </a>
                            </div>

                            <div class="justify-center">
                                <x-primary-button id="button-login">
                                    {{ __('Entrar') }}
                                </x-primary-button>
                            </div>
                            <div class="justify-center">
                                <hr/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-guest-layout>
