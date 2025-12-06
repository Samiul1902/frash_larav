<x-app-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-[-10%] left-[20%] w-96 h-96 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative z-10 sm:max-w-3xl sm:mx-auto w-full">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-gray-600">
                    Generate Invoice
                </h2>
                <p class="mt-2 text-gray-500">Finalize billing for Appointment #{{ $appointment->id }}</p>
            </div>

            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-white/20">
                <div class="grid grid-cols-1 md:grid-cols-5 h-full">
                    
                    <!-- Left Column: Details -->
                    <div class="col-span-3 p-8 border-r border-gray-100">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Booking Summary</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-sm font-medium text-gray-400 uppercase tracking-wider">Customer</span>
                                <span class="text-gray-900 font-semibold">{{ $appointment->user->name }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-sm font-medium text-gray-400 uppercase tracking-wider">Service</span>
                                <span class="text-gray-900 font-semibold">{{ $appointment->service->title }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-sm font-medium text-gray-400 uppercase tracking-wider">Stylist</span>
                                <span class="text-gray-900 font-semibold">{{ $appointment->staff->name ?? 'Unassigned' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-50">
                                <span class="text-sm font-medium text-gray-400 uppercase tracking-wider">Date & Time</span>
                                <span class="text-gray-900 font-semibold">{{ $appointment->start_time->format('M d, Y • h:i A') }}</span>
                            </div>
                        </div>

                        <div class="mt-8 p-4 bg-yellow-50 rounded-xl border border-yellow-100">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Review Before Confirming</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Ensure all services rendered are included. This action will generate a formal invoice.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Amount & Action -->
                    <div class="col-span-2 bg-gray-50/50 p-8 flex flex-col justify-between">
                        <form action="{{ route('admin.invoices.store') }}" method="POST" class="h-full flex flex-col">
                            @csrf
                            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                            <div>
                                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Payment Details</h3>
                                
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Total Amount (BDT)</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-lg">৳</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" value="{{ $appointment->service->price }}" step="0.01" 
                                           class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-8 pr-12 sm:text-2xl border-gray-300 rounded-xl py-3 font-bold text-gray-900 bg-white" 
                                           required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Bt</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto space-y-3 pt-8">
                                <button type="submit" 
                                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:-translate-y-0.5 transition-all">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Confirm & Print
                                </button>
                                
                                <a href="{{ route('admin.appointments.index') }}" 
                                   class="w-full flex justify-center items-center py-3 px-4 border border-gray-200 rounded-xl shadow-sm text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
