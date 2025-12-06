<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Appointments -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 shadow-lg text-white transform hover:scale-105 transition duration-300">
                    <div class="text-blue-100 text-sm font-semibold uppercase tracking-wider">Total Bookings</div>
                    <div class="text-4xl font-extrabold mt-2">{{ $stats['total_appointments'] }}</div>
                    <div class="mt-4 text-blue-200 text-xs">All time bookings</div>
                </div>
                <!-- Today's Bookings -->
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 shadow-lg text-white transform hover:scale-105 transition duration-300">
                    <div class="text-indigo-100 text-sm font-semibold uppercase tracking-wider">Today's Bookings</div>
                    <div class="text-4xl font-extrabold mt-2">{{ $stats['appointments_today'] }}</div>
                    <div class="mt-4 text-indigo-200 text-xs">Scheduled for today</div>
                </div>
                <!-- Revenue -->
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 shadow-lg text-white transform hover:scale-105 transition duration-300">
                    <div class="text-green-100 text-sm font-semibold uppercase tracking-wider">Total Revenue</div>
                    <div class="text-4xl font-extrabold mt-2">৳{{ number_format($stats['revenue_total']) }}</div>
                    <div class="mt-4 text-green-200 text-xs">Confirmed earnings</div>
                </div>
                <!-- Active Staff -->
                <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl p-6 shadow-lg text-white transform hover:scale-105 transition duration-300">
                    <div class="text-pink-100 text-sm font-semibold uppercase tracking-wider">Active Staff</div>
                    <div class="text-4xl font-extrabold mt-2">{{ $stats['active_staff'] }}</div>
                    <div class="mt-4 text-pink-200 text-xs">Ready for service</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Appointments -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-800">Recent Appointments</h3>
                        <a href="{{ route('admin.appointments.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold transition">View All &rarr;</a>
                    </div>
                    <div class="p-0">
                        @if($recent_appointments->count() > 0)
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Customer</th>
                                        <th class="px-6 py-4 font-semibold">Service</th>
                                        <th class="px-6 py-4 font-semibold">Date</th>
                                        <th class="px-6 py-4 font-semibold text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($recent_appointments as $appt)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="font-bold text-gray-900">{{ $appt->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $appt->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                <span class="bg-indigo-50 text-indigo-700 px-2 py-1 rounded-md text-xs font-semibold">{{ $appt->service->title }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $appt->start_time->format('d M, h:i A') }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $appt->status == 'confirmed' ? 'bg-green-100 text-green-800' : 
                                                       ($appt->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                       ($appt->status == 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                                    {{ ucfirst($appt->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-8 text-center text-gray-500">
                                <p>No bookings found.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 h-fit">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-800">Quick Actions</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 gap-4">
                        <a href="{{ route('admin.services.create') }}" class="group flex items-center p-4 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-600 hover:text-white transition duration-300 font-semibold shadow-sm overflow-hidden relative">
                            <span class="absolute right-0 bottom-0 opacity-10 transform translate-y-2 translate-x-2">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v2a1 1 0 01-2 0v-2H5a1 1 0 010-2h2V9a1 1 0 012 0v2h2a1 1 0 010 2z"/></svg>
                            </span>
                            <span class="mr-3 text-2xl group-hover:scale-110 transition">+</span> New Service
                        </a>
                        <a href="{{ route('admin.staff.create') }}" class="group flex items-center p-4 bg-purple-50 text-purple-700 rounded-xl hover:bg-purple-600 hover:text-white transition duration-300 font-semibold shadow-sm overflow-hidden relative">
                            <span class="absolute right-0 bottom-0 opacity-10 transform translate-y-2 translate-x-2">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                            </span>
                            <span class="mr-3 text-2xl group-hover:scale-110 transition">+</span> Add Staff
                        </a>
                        <a href="{{ route('admin.branches.index') }}" class="group flex items-center p-4 bg-orange-50 text-orange-700 rounded-xl hover:bg-orange-600 hover:text-white transition duration-300 font-semibold shadow-sm overflow-hidden relative">
                            <span class="absolute right-0 bottom-0 opacity-10 transform translate-y-2 translate-x-2">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/></svg>
                            </span>
                            <span class="mr-3 text-2xl group-hover:scale-110 transition">🏢</span> Manage Branches
                        </a>
                        <a href="{{ route('admin.appointments.index') }}" class="group flex items-center p-4 bg-green-50 text-green-700 rounded-xl hover:bg-green-600 hover:text-white transition duration-300 font-semibold shadow-sm overflow-hidden relative">
                            <span class="absolute right-0 bottom-0 opacity-10 transform translate-y-2 translate-x-2">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                            </span>
                            <span class="mr-3 text-2xl group-hover:scale-110 transition">📅</span> Manage Bookings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
