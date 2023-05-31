<x-app-layout >
    <x-slot name="header">
        <h2 class="justify-center">
            {{ __('Perfil') }}
        </h2>
    </x-slot>

    <div>
        <div >
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>
</x-app-layout>
