<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.services.index')" :active="request()->routeIs('admin.services.*')">
                            {{ __('Services') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.staff.index')" :active="request()->routeIs('admin.staff.*')">
                            {{ __('Staff') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.appointments.index')" :active="request()->routeIs('admin.appointments.*')">
                            {{ __('Bookings') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                            {{ __('Settings') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.*')">
                            {{ __('My Bookings') }}
                        </x-nav-link>
                    @endif
                    <!-- AI Assistant Link -->
                    <x-nav-link :href="route('ai.image.index')" :active="request()->routeIs('ai.image.index')" class="text-pink-600 font-bold">
                        {{ __('Create Style') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                
                <!-- Notification Bell -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = ! open" class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="open" @click.away="open = false" 
                         class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden z-50 border border-gray-100"
                         style="display: none;">
                        <div class="py-2">
                            <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                                <span class="text-sm font-semibold text-gray-700">Notifications</span>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <form method="POST" action="{{ route('notifications.markAsRead') }}">
                                        @csrf
                                        <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 font-medium">Mark all read</button>
                                    </form>
                                @endif
                            </div>
                            
                            <div class="max-h-64 overflow-y-auto">
                                @forelse(Auth::user()->unreadNotifications as $notification)
                                    <a href="{{ $notification->data['link'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-100 last:border-0">
                                        <p class="text-sm text-gray-800">{{ $notification->data['message'] ?? 'New Notification' }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </a>
                                @empty
                                    <div class="px-4 py-6 text-center text-gray-500 text-sm">
                                        No new notifications
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex flex-col items-end">
                                <div>{{ Auth::user()->name }}</div>
                                @if(Auth::user()->role !== 'admin')
                                    <div class="text-xs text-purple-600 font-bold">{{ Auth::user()->loyalty_points }} pts</div>
                                @endif
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="text-red-600 font-semibold">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
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
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.services.index')" :active="request()->routeIs('admin.services.*')">
                    {{ __('Services') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.staff.index')" :active="request()->routeIs('admin.staff.*')">
                    {{ __('Staff') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.appointments.index')" :active="request()->routeIs('admin.appointments.*')">
                    {{ __('Bookings') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                    {{ __('Settings') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.*')">
                    {{ __('My Bookings') }}
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('ai.image.index')" :active="request()->routeIs('ai.image.index')" class="text-pink-600 font-bold">
                {{ __('Create Style (AI)') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
