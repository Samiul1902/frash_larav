<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats & Quick Actions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Quick Actions -->
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-purple-100 flex flex-col justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-2">Quick Actions</h3>
                        <div class="flex flex-col space-y-3">
                            <a href="{{ route('services.index') }}" class="flex items-center justify-between p-3 bg-purple-50 rounded-xl text-purple-700 font-bold hover:bg-purple-100 transition group">
                                <span>Book Appointment</span>
                                <span class="group-hover:translate-x-1 transition text-xl">→</span>
                            </a>
                            <a href="{{ route('ai.image.index') }}" class="flex items-center justify-between p-3 bg-pink-50 rounded-xl text-pink-700 font-bold hover:bg-pink-100 transition group">
                                <span>Create Style (AI)</span>
                                <span class="group-hover:translate-x-1 transition text-xl">✨</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Active Bookings Stat -->
                <div class="bg-gradient-to-br from-blue-500 to-cyan-500 p-6 rounded-2xl shadow-lg text-white flex flex-col justify-between">
                    <div>
                        <h3 class="text-blue-100 text-sm font-bold uppercase tracking-wider">Active Bookings</h3>
                        <p class="text-4xl font-extrabold mt-2">{{ \App\Models\Appointment::where('user_id', Auth::id())->whereIn('status', ['pending', 'confirmed'])->count() }}</p>
                    </div>
                    <a href="{{ route('appointments.index') }}" class="text-sm font-medium text-blue-100 hover:text-white mt-4 inline-flex items-center">
                        View Details <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <!-- Explore Services -->
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 flex flex-col justify-between relative overflow-hidden group">
                    <div class="relative z-10">
                        <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Discover</h3>
                        <h2 class="text-2xl font-bold text-gray-800 mt-1">New Services</h2>
                        <p class="text-gray-500 text-sm mt-2">Check out our latest treatments.</p>
                    </div>
                    <div class="absolute right-[-20px] bottom-[-20px] opacity-10 group-hover:opacity-20 transition transform group-hover:scale-110">
                        <svg class="w-32 h-32 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"></path></svg>
                    </div>
                    <a href="{{ route('services.index') }}" class="btn btn-sm btn-outline relative z-10 mt-4 text-purple-600 font-bold">Browse Menu</a>
                </div>
            </div>

            <!-- Toast Notification (Only appears if session has 'success') -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="fixed top-20 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-xl flex items-center space-x-2 z-50 animate-bounce-in">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Your Recent Activity</h3>
                    <p class="text-gray-500 italic">No recent bookings found. Time for a fresh look?</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
