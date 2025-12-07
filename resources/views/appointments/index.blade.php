<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Appointments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">History</h3>
                <a href="{{ route('appointments.create') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition transform hover:scale-105">
                    + Book New Appointment
                </a>
            </div>

            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="fixed top-20 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-xl flex items-center space-x-2 z-50 animate-bounce-in">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Stylist</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Duration</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($appointments as $appointment)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-5 py-5 bg-white text-sm">
                                    <div class="font-bold text-gray-900">{{ $appointment->service->title }}</div>
                                    <div class="text-xs text-gray-500">Base: ৳{{ number_format($appointment->service->price) }}</div>
                                </td>
                                <td class="px-5 py-5 bg-white text-sm">
                                    <div class="text-gray-900 font-bold">৳{{ number_format($appointment->service->price - ($appointment->discount_amount ?? 0), 2) }}</div>
                                    @if($appointment->discount_amount > 0)
                                        <div class="text-xs text-green-600 font-semibold">Saved ৳{{ number_format($appointment->discount_amount, 2) }}</div>
                                    @endif
                                </td>
                                <td class="px-5 py-5 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $appointment->staff->name }}</p>
                                </td>
                                <td class="px-5 py-5 bg-white text-sm">
                                    <div class="text-gray-900 font-medium">{{ $appointment->start_time->format('M d, Y') }}</div>
                                    <div class="text-gray-500 text-xs">{{ $appointment->start_time->format('h:i A') }}</div>
                                </td>
                                <td class="px-5 py-5 bg-white text-sm">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-medium">{{ $appointment->service->duration_minutes }} mins</span>
                                </td>
                                <td class="px-5 py-5 bg-white text-sm">
                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight 
                                        {{ $appointment->status === 'confirmed' ? 'text-green-800' : 
                                           ($appointment->status === 'pending' ? 'text-yellow-800' : 
                                           ($appointment->status === 'completed' ? 'text-blue-800' : 'text-red-800')) }}">
                                        <span aria-hidden class="absolute inset-0 opacity-20 rounded-full 
                                            {{ $appointment->status === 'confirmed' ? 'bg-green-500' : 
                                               ($appointment->status === 'pending' ? 'bg-yellow-500' : 
                                               ($appointment->status === 'completed' ? 'bg-blue-500' : 'bg-red-500')) }}"></span>
                                        <span class="relative">{{ ucfirst($appointment->status) }}</span>
                                    </span>
                                    
                                    @if($appointment->status === 'completed')
                                        <div class="mt-2">
                                            <a href="{{ route('reviews.create', ['appointment_id' => $appointment->id]) }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                                Leave a Review
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-5 bg-white text-sm">
                                    @if(in_array($appointment->status, ['pending', 'confirmed']))
                                        <div class="flex space-x-2">
                                            <a href="{{ route('appointments.edit', $appointment->id) }}" class="text-blue-600 hover:text-blue-900 font-bold text-xs bg-blue-100 hover:bg-blue-200 px-3 py-1 rounded transition">
                                                Reschedule
                                            </a>
                                            <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-xs bg-red-100 hover:bg-red-200 px-3 py-1 rounded transition">
                                                    Cancel
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs italic">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 bg-white text-sm text-center text-gray-500">
                                    <p class="text-lg mb-2">You have no appointments yet.</p>
                                    <a href="{{ route('services.index') }}" class="text-purple-600 hover:text-purple-800 font-bold">Browse Services</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
            <div class="mt-4">
                {{-- Pagination Links could go here if implemented --}}
            </div>
        </div>
    </div>
</x-app-layout>
