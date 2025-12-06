<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl shadow-xl overflow-hidden p-8 text-white mb-8">
                <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-purple-100">Manage your appointments and explore our latest styles.</p>
                <div class="mt-6 flex space-x-4">
                    <a href="{{ route('services.index') }}" class="bg-white text-purple-600 px-6 py-2 rounded-full font-bold shadow-md hover:bg-gray-100 transition">
                        Book Appointment
                    </a>
                    <a href="{{ route('ai.image.index') }}" class="bg-purple-700 bg-opacity-50 text-white px-6 py-2 rounded-full font-bold shadow-md hover:bg-opacity-70 transition border border-purple-400">
                        Create Style
                    </a>
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
