@section('title', 'Atualizar perfil')

<section>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <div class="justify-content container-login">
        <form method="post" action="{{ route('profile.update') }}" class="card-update">
            @csrf
            @method('patch')

            <div class="label-float-update">
                <x-input-label class="justify-center" for="name" :value="__('Nome')" />
                <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="label-float-update">
                <x-input-label class="justify-center" for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p >
                            {{ __('Seu email não é verificado.') }}

                            <button form="send-verification" >
                                {{ __('Clique aqui para re-enviar a verificação por email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p >
                                {{ __('Um novo link de verificação foi enviado.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
            

            <div class="justify-center">
                <x-primary-button id="button-update">{{ __('Atualizar') }}</x-primary-button>
            </div>
        </form>
    </div>

    <div>
        <br>
        <p>
            {{ __("Atualize as informações do seu perfil.") }}
        </p>
        <br>

        @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="justify-center"
            >{{ __('Atualizado com sucesso.') }}</p>
        @endif
    </div>
</section>
