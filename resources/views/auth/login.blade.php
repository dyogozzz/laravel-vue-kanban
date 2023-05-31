@section('title', 'Entrar')

<x-guest-layout>
    <x-auth-session-status class="custom-status-message" :status="session('status')" />

        <div id="body">
            <div class="container-login">
                <div class="card-login">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h2 class="justify-center" id="h2-auth">Entrar</h2>

                        <div class="label-float">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="label-float">
                            <x-input-label id="labelSenha" for="password" :value="__('Senha')" />

                            <x-text-input id="password"
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
                            <div >
                                <a style="padding-bottom:3px;" id="forgot" href="/register">
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
