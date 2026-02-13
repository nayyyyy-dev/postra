<nav x-data="{ open: false }"
     class="sticky top-0 z-40 bg-gradient-to-r from-blue-600 to-sky-500 shadow-md">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-white text-blue-600 flex items-center justify-center font-bold">
                    P
                </div>
                <div class="hidden sm:block text-white font-semibold">
                    Postra
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden sm:flex items-center gap-2">

                @php
                    $base = 'px-4 py-2 rounded-xl text-sm font-semibold transition';
                    $active = 'bg-white text-blue-600';
                    $idle = 'text-white hover:bg-white/20';
                @endphp

                <a href="{{ route('dashboard') }}"
                   class="{{ $base }} {{ request()->routeIs('dashboard') ? $active : $idle }}">
                    Dashboard
                </a>

                <a href="{{ route('letters.index') }}"
                   class="{{ $base }} {{ request()->routeIs('letters.*') ? $active : $idle }}">
                    Surat
                </a>

                @if(auth()->user()->hasRole('super-admin'))
                    <a href="{{ route('users.index') }}"
                       class="{{ $base }} {{ request()->routeIs('users.*') ? $active : $idle }}">
                        User
                    </a>
                @endif
            </div>

            <!-- Right User -->
            <div class="hidden sm:flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 text-white hover:opacity-80 transition">
                            <div class="h-9 w-9 rounded-full bg-white text-blue-600 flex items-center justify-center font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:block text-sm font-semibold">
                                {{ Auth::user()->name }}
                            </span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Button -->
            <button @click="open = ! open"
                class="sm:hidden text-white focus-ring">
                ☰
            </button>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}"
         class="hidden sm:hidden bg-blue-700 text-white">

        <div class="px-4 py-3 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20">
                Dashboard
            </a>

            <a href="{{ route('letters.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20">
                Surat
            </a>

            @if(auth()->user()->hasRole('super-admin'))
                <a href="{{ route('users.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20">
                    User
                </a>
            @endif

            <div class="border-t border-white/30 mt-3 pt-3">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 rounded-lg hover:bg-white/20">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded-lg hover:bg-white/20">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
