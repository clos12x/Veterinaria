<nav x-data="{ open: false }" class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- Logo --}}
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-purple-700 dark:text-white" />
                </a>

                {{-- Enlaces principales --}}
                <div class="hidden sm:flex gap-6">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>
                </div>
            </div>

            {{-- Selector de tema y usuario --}}
            <div class="hidden sm:flex items-center gap-6">

                {{-- Cambiar tema --}}
                <form method="POST" action="{{ route('cambiar.tema') }}">
                    @csrf
                    <select name="tema" onchange="this.form.submit()"
                        class="rounded px-2 py-1 bg-white text-black dark:bg-gray-800 dark:text-white text-sm">
                        <option value="tema-nino" {{ session('tema') == 'tema-nino' ? 'selected' : '' }}>Niños</option>
                        <option value="tema-joven" {{ session('tema') == 'tema-joven' ? 'selected' : '' }}>Jóvenes</option>
                        <option value="tema-adulto" {{ session('tema') == 'tema-adulto' ? 'selected' : '' }}>Adultos</option>
                        <option value="tema-dia" {{ session('tema') == 'tema-dia' ? 'selected' : '' }}>Día</option>
                        <option value="tema-noche" {{ session('tema') == 'tema-noche' ? 'selected' : '' }}>Noche</option>
                    </select>
                </form>

                {{-- Dropdown de usuario --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 rounded-md text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06 0L10 10.91l3.71-3.7a.75.75 0 011.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 010-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Cerrar sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Botón hamburguesa (móvil) --}}
            <div class="-mr-2 flex sm:hidden">
                <button @click="open = ! open"
                    class="p-2 rounded-md text-gray-500 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menú móvil --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden hidden">
        <div class="pt-4 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 pb-1">
            <div class="px-4 text-sm">
                <div class="font-semibold text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                <div class="text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

