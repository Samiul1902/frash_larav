<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden p-8 md:p-12">
                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('appointments.store') }}" method="POST" id="booking-form" class="space-y-6">
                    @csrf
                    
                    <!-- Progress / Steps Indicator -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center font-bold text-sm">1</div>
                            <span class="text-xs mt-1 font-medium text-purple-600">Details</span>
                        </div>
                        <div class="flex-1 h-1 bg-gray-200 mx-2 rounded-full relative">
                            <div class="absolute top-0 left-0 h-full bg-purple-600 w-1/2 rounded-full"></div>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-sm">2</div>
                            <span class="text-xs mt-1 font-medium text-gray-500">Confirm</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Service & Staff -->
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Service Details</h3>
                            
                            <!-- Branch Selection -->
                            <div class="mb-4">
                                <label class="block text-gray-600 text-sm font-bold mb-2">Select Branch</label>
                                <select id="branch_id" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                                    <option value="">-- Choose a Branch --</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-600 text-sm font-bold mb-2">Select Service</label>
                                <select name="service_id" id="service_id" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition disabled:bg-gray-100 disabled:text-gray-400" required disabled>
                                    <option value="">-- First Select a Branch --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-branch-id="{{ $service->branch_id }}">{{ $service->title }} (৳{{ $service->price }} - {{ $service->duration_minutes }} mins)</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-600 text-sm font-bold mb-2">Select Stylist</label>
                                <select name="staff_id" id="staff_id" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition disabled:bg-gray-100 disabled:text-gray-400" required disabled>
                                    <option value="">-- First Select a Branch --</option>
                                    @foreach($staff as $member)
                                        <option value="{{ $member->id }}" data-branch-id="{{ $member->branch_id }}">{{ $member->name }} ({{ $member->specialization }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Date & Time -->
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Date & Time</h3>
                            
                            <div class="mb-4">
                                <label class="block text-gray-600 text-sm font-bold mb-2">Date</label>
                                <input type="date" name="appointment_date" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required min="{{ date('Y-m-d') }}">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-600 text-sm font-bold mb-2">Time</label>
                                <input type="time" name="appointment_time" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition" required>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm mt-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Payment Method</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Cash Option -->
                            <label class="cursor-pointer relative">
                                <input type="radio" name="payment_method" value="cash" class="peer sr-only" checked>
                                <div class="p-4 rounded-xl border-2 border-gray-200 hover:border-purple-200 peer-checked:border-purple-600 peer-checked:bg-purple-50 transition-all">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800">Pay on Arrival</h4>
                                            <p class="text-xs text-gray-500">Cash or Card at the salon</p>
                                        </div>
                                    </div>
                                    <div class="absolute top-4 right-4 text-purple-600 hidden peer-checked:block">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    </div>
                                </div>
                            </label>

                            <!-- Online Option -->
                            <label class="cursor-pointer relative">
                                <input type="radio" name="payment_method" value="online" class="peer sr-only">
                                <div class="p-4 rounded-xl border-2 border-gray-200 hover:border-purple-200 peer-checked:border-purple-600 peer-checked:bg-purple-50 transition-all">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800">Pay Online</h4>
                                            <p class="text-xs text-gray-500">Secure Credit/Debit Card</p>
                                        </div>
                                    </div>
                                    <div class="absolute top-4 right-4 text-purple-600 hidden peer-checked:block">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t border-gray-100 pt-6">
                        <button class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition hover:scale-105" type="submit">
                            Confirm Booking <span id="price-display"></span>
                        </button>
                    </div>
                </form>

                <script>
                    const branchSelect = document.getElementById('branch_id');
                    const serviceSelect = document.getElementById('service_id');
                    const staffSelect = document.getElementById('staff_id');
                    const priceDisplay = document.getElementById('price-display');

                    // Store original options
                    const allServices = Array.from(serviceSelect.options).slice(1); // Skip placeholder
                    const allStaff = Array.from(staffSelect.options).slice(1); // Skip placeholder

                    branchSelect.addEventListener('change', function() {
                        const branchId = this.value;
                        
                        // Reset and Disable/Enable Dropdowns
                        serviceSelect.innerHTML = '<option value="">-- Choose a Service --</option>';
                        staffSelect.innerHTML = '<option value="">-- Choose a Stylist --</option>';
                        priceDisplay.textContent = '';
                        
                        if (branchId) {
                            serviceSelect.disabled = false;
                            staffSelect.disabled = false;

                            // Filter Services
                            const filteredServices = allServices.filter(opt => opt.getAttribute('data-branch-id') == branchId || !opt.getAttribute('data-branch-id'));
                            filteredServices.forEach(opt => serviceSelect.add(opt.cloneNode(true)));
                            
                            // Filter Staff
                            const filteredStaff = allStaff.filter(opt => opt.getAttribute('data-branch-id') == branchId);
                            filteredStaff.forEach(opt => staffSelect.add(opt.cloneNode(true)));

                            if (filteredServices.length === 0) {
                                serviceSelect.innerHTML = '<option value="">-- No Services Available --</option>';
                                serviceSelect.disabled = true;
                            }
                            if (filteredStaff.length === 0) {
                                staffSelect.innerHTML = '<option value="">-- No Stylists Available --</option>';
                                staffSelect.disabled = true;
                            }

                        } else {
                            serviceSelect.innerHTML = '<option value="">-- First Select a Branch --</option>';
                            staffSelect.innerHTML = '<option value="">-- First Select a Branch --</option>';
                            serviceSelect.disabled = true;
                            staffSelect.disabled = true;
                        }
                    });

                    serviceSelect.addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        const price = selectedOption.getAttribute('data-price');
                        if (price) {
                            priceDisplay.textContent = '(৳' + price + ')';
                        } else {
                            priceDisplay.textContent = '';
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
