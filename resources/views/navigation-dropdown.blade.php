<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-nav-link>
                    <!-- System Maps -->
                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                {{ __('System Maps') }}
                            </button>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('3D') }}
                            </div>
                            <x-jet-dropdown-link href="{{ route('maps.nebulonSystem3D') }}">
                                &nbsp;&nbsp; Nebulon
                            </x-jet-dropdown-link>
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('2D') }}
                            </div>
                            <x-jet-dropdown-link href="{{ route('maps.nebulonSystem') }}">
                                &nbsp; Nebulon
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                    <!-- Transactions -->
                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                {{ __('Transactions') }}
                            </button>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Orders') }}
                            </div>
                            <x-jet-dropdown-link href="{{ route('orders.ores') }}">
                                &nbsp;&nbsp; Ores
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('orders.ingots') }}">
                                &nbsp;&nbsp; Ingots
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('orders.components') }}">
                                &nbsp;&nbsp; Components
                            </x-jet-dropdown-link>
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Offers') }}
                            </div>
                            <x-jet-dropdown-link href="{{ route('offers.ores') }}">
                                &nbsp;&nbsp; Ores
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('offers.ingots') }}">
                                &nbsp;&nbsp; Ingots
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('offers.components') }}">
                                &nbsp;&nbsp;Components
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                    <!-- Stores -->
                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                {{ __('Stores') }}
                            </button>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="content">
                            <x-jet-dropdown-link href="{{ route('stores') }}">
                              {{ __('Personal') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('stores.world') }}">
                                {{ __('World') }}
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('stores.server') }}">
                                {{ __('Server') }}
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                    <!-- Trends -->
                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                {{ __('Trends') }}
                            </button>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Ores') }}
                            </div>
                            <x-jet-dropdown-link href="{{ route('trends.ores.orders') }}">
                                &nbsp;&nbsp; Order
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('trends.ores.offers') }}">
                                &nbsp;&nbsp; Offer
                            </x-jet-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Ingots') }}
                            </div>
                            <x-jet-dropdown-link href="{{ route('trends.ingots.orders') }}">
                                &nbsp;&nbsp; Order
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('trends.ingots.offers') }}">
                                &nbsp;&nbsp; Offer
                            </x-jet-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Componts') }}
                            </div>
                            <x-jet-dropdown-link href="{{ route('trends.components.orders') }}">
                                &nbsp;&nbsp; Order
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('trends.components.offers') }}">
                                &nbsp;&nbsp; Offer
                            </x-jet-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Tools') }}
                            </div>
                            <x-jet-dropdown-link href="{{ route('trends.tools.orders') }}">
                                &nbsp;&nbsp; Order
                            </x-jet-dropdown-link>
                            <x-jet-dropdown-link href="{{ route('trends.tools.offers') }}">
                                &nbsp;&nbsp; Offer
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                    <!--Staleness -->
                    @livewire('staleness-info')
                    <!-- Testing -->
                    <x-jet-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                {{ __('Testing') }}
                            </button>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </x-slot>
                        <x-slot name="content">
                            <x-jet-dropdown-link href="{{ route('stocklevels') }}">
                                Stock Levels
                            </x-jet-dropdown-link>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Administration Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-jet-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>@livewire('active-server')</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- World Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Worlds') }}
                        </div>
                        <x-jet-dropdown-link href="{{ route('admin.worlds') }}">
                            &nbsp;&nbsp;{{ __('List') }}
                        </x-jet-dropdown-link>
                        <x-jet-dropdown-link href="{{ route('admin.worlds.create') }}">
                            &nbsp;&nbsp;{{ __('Create') }}
                        </x-jet-dropdown-link>
                        <div class="border-t border-gray-100"></div>
                        <!-- Server Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Servers') }}
                        </div>
                        <x-jet-dropdown-link href="{{ route('admin.servers') }}">
                            &nbsp;&nbsp;{{ __('List') }}
                        </x-jet-dropdown-link>
                        <x-jet-dropdown-link href="{{ route('admin.servers.create') }}">
                            &nbsp;&nbsp;{{ __('Create') }}
                        </x-jet-dropdown-link>
                        <div class="border-t border-gray-100"></div>
                        <!-- User Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Users') }}
                        </div>
                        <x-jet-dropdown-link href="{{ route('admin.users') }}">
                            &nbsp;&nbsp;{{ __('List') }}
                        </x-jet-dropdown-link>
                        <x-jet-dropdown-link href="{{ route('admin.users.owners') }}">
                            &nbsp;&nbsp;{{ __('Owners') }}
                        </x-jet-dropdown-link>
                    </x-slot>
                </x-jet-dropdown>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-jet-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->username }}" />
                            </button>
                        @else
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        @endif
                    </x-slot>

                    <x-slot name="content">
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Account') }}
                        </div>

                        <x-jet-dropdown-link href="{{ route('profile.show') }}">
                            {{ __('Profile') }}
                        </x-jet-dropdown-link>

                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                {{ __('API Tokens') }}
                            </x-jet-dropdown-link>
                        @endif

                        <div class="border-t border-gray-100"></div>

                        <!-- Team Management -->
                        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Team') }}
                            </div>

                            <!-- Team Settings -->
                            <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                {{ __('Team Settings') }}
                            </x-jet-dropdown-link>

                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                    {{ __('Create New Team') }}
                                </x-jet-dropdown-link>
                            @endcan

                            <div class="border-t border-gray-100"></div>

                            <!-- Team Switcher -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Teams') }}
                            </div>

                            @foreach (Auth::user()->allTeams() as $team)
                                <x-jet-switchable-team :team="$team" />
                            @endforeach

                            <div class="border-t border-gray-100"></div>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-jet-dropdown-link href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                {{ __('Logout') }}
                            </x-jet-dropdown-link>
                        </form>
                    </x-slot>
                </x-jet-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </div>

                <div class="ml-3">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Logout') }}
                    </x-jet-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                        {{ __('Create New Team') }}
                    </x-jet-responsive-nav-link>

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
