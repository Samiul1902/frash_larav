<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Appointments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">All Appointments</h3>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Service</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stylist</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date & Time</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">#{{ $appointment->id }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $appointment->user->name }}</p>
                                            <p class="text-gray-600 text-xs">{{ $appointment->user->phone }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $appointment->service->title }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $appointment->staff->name }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $appointment->start_time->format('M d, Y') }}</p>
                                            <p class="text-gray-600 text-xs">{{ $appointment->start_time->format('h:i A') }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">৳{{ $appointment->service->price }}</p>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <span class="relative inline-block px-3 py-1 font-semibold leading-tight 
                                                {{ $appointment->status === 'confirmed' ? 'text-green-900' : 
                                                   ($appointment->status === 'pending' ? 'text-yellow-900' : 
                                                   ($appointment->status === 'completed' ? 'text-blue-900' : 'text-red-900')) }}">
                                                <span aria-hidden class="absolute inset-0 opacity-50 rounded-full 
                                                    {{ $appointment->status === 'confirmed' ? 'bg-green-200' : 
                                                       ($appointment->status === 'pending' ? 'bg-yellow-200' : 
                                                       ($appointment->status === 'completed' ? 'bg-blue-200' : 'bg-red-200')) }}"></span>
                                                <span class="relative">{{ ucfirst($appointment->status) }}</span>
                                            </span>
                                        </td>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            @if($appointment->status === 'pending')
                                                <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="text-white bg-green-500 hover:bg-green-700 font-bold py-1 px-2 rounded text-xs mr-1">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="text-white bg-red-500 hover:bg-red-700 font-bold py-1 px-2 rounded text-xs">
                                                        Reject
                                                    </button>
                                                </form>
                                            @elseif($appointment->status === 'confirmed')
                                                <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="text-white bg-blue-500 hover:bg-blue-700 font-bold py-1 px-2 rounded text-xs mr-1">
                                                        Complete
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="text-gray-500 hover:text-gray-700 text-xs underline">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @elseif($appointment->status === 'completed')
                                                @if($appointment->invoice)
                                                    <a href="{{ route('admin.invoices.show', $appointment->invoice->id) }}" class="text-white bg-purple-500 hover:bg-purple-700 font-bold py-1 px-2 rounded text-xs">
                                                        View Invoice
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.invoices.create', ['appointment_id' => $appointment->id]) }}" class="text-white bg-indigo-500 hover:bg-indigo-700 font-bold py-1 px-2 rounded text-xs">
                                                        Generate Invoice
                                                    </a>
                                                @endif
                                            @else
                                                <span class="text-gray-500 text-xs">No actions</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
