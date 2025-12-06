<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Invoice Details</h3>
                    
                    <div class="mb-6 p-4 bg-gray-50 rounded">
                        <p><strong>Appointment ID:</strong> #{{ $appointment->id }}</p>
                        <p><strong>Customer:</strong> {{ $appointment->user->name }}</p>
                        <p><strong>Service:</strong> {{ $appointment->service->title }}</p>
                        <p><strong>Date:</strong> {{ $appointment->start_time->format('M d, Y') }}</p>
                    </div>

                    <form action="{{ route('admin.invoices.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                        
                        <div class="mb-4">
                            <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Total Amount (BDT):</label>
                            <input type="number" name="amount" id="amount" value="{{ $appointment->service->price }}" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Generate Invoice
                            </button>
                            <a href="{{ route('admin.appointments.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
