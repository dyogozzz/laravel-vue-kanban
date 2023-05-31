<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
<div class="navbar">
        <a href="/products">Home</a>

        <div class="dropdown">
            <button class="drop-btn">Área de trabalho</button>

            <div class="dropdown-content">
                <a href="#home">link 1</a>
                <a href="#home">Link 2</a>
                <a href="#home">Link 3</a>
            </div>
        </div>

        <div class="dropdown">
            <button class="drop-btn">Recentes</button>

            <div class="dropdown-content">
                <a href="#home">link 1</a>
                <a href="#home">Link 2</a>
                <a href="#home">Link 3</a>
            </div>
        </div>

        <div class="dropdown">
            <button class="drop-btn">{{ __('Perfil') }}</button>

            <div class="dropdown-content">
            <x-dropdown-link href="#">
                    {{ Auth::user()->name }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
            </div>
        </div>
    </div>
    <br />
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div id="logo" class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo id="svg-logo" class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
        </div>
</nav>
