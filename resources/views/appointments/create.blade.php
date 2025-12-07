<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
                                <input type="date" id="appointment_date" name="appointment_date" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition disabled:bg-gray-100 disabled:text-gray-400" required min="{{ date('Y-m-d') }}" disabled>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-600 text-sm font-bold mb-2">Select Time</label>
                                
                                <div id="slots-loading" class="hidden text-center py-4">
                                    <svg class="animate-spin h-6 w-6 text-purple-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-xs text-gray-500 mt-2 block">Finding available slots...</span>
                                </div>

                                <div id="slots-container" class="grid grid-cols-3 gap-2">
                                    <p class="text-sm text-gray-400 col-span-3 text-center py-4">Select a stylist and date first.</p>
                                </div>
                                <input type="hidden" name="appointment_time" id="appointment_time" required>
                                <div id="slot-error" class="hidden text-red-500 text-xs mt-2 text-center"></div>
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

                    <!-- Loyalty Points Redemption -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm mt-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center justify-between">
                            Loyalty Points
                            <span class="text-sm font-normal text-purple-600 bg-purple-100 px-3 py-1 rounded-full">
                                Balance: {{ Auth::user()->loyalty_points }} pts
                            </span>
                        </h3>
                        
                        @if(Auth::user()->loyalty_points > 0)
                            <div class="mt-4">
                                <label for="redeem_points" class="block text-sm font-medium text-gray-700">
                                    Redeem Points (Max: {{ Auth::user()->loyalty_points }} pts)
                                    <span class="text-xs text-gray-400 block">1 Point = {{ \App\Models\Setting::getValue('loyalty_redeem_value', 10) }} Tk</span>
                                </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="number" name="redeem_points" id="redeem_points" min="0" max="{{ Auth::user()->loyalty_points }}" placeholder="Enter points to redeem"
                                        class="focus:ring-purple-500 focus:border-purple-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                                </div>
                                <p id="savings-display" class="text-sm text-green-600 font-bold mt-2 hidden">Savings: <span id="savings-amount">0</span> Tk</p>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 italic">Play more to earn discount! You need at least 1 point to redeem.</p>
                        @endif
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t border-gray-100 pt-6">
                        <button id="submit-btn" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition hover:scale-105" type="submit">
                            Confirm Booking <span id="price-display"></span>
                        </button>
                    </div>

                    <!-- Script moved to main block below to share scope -->
                </form>

                <script>
                    const branchSelect = document.getElementById('branch_id');
                    const serviceSelect = document.getElementById('service_id');
                    const staffSelect = document.getElementById('staff_id');
                    const dateInput = document.getElementById('appointment_date');
                    const timeInput = document.getElementById('appointment_time');
                    const priceDisplay = document.getElementById('price-display');
                    
                    const slotsContainer = document.getElementById('slots-container');
                    const slotsLoading = document.getElementById('slots-loading');
                    const slotError = document.getElementById('slot-error');

                    // Store original options
                    const allServices = Array.from(serviceSelect.options).slice(1); // Skip placeholder
                    const allStaff = Array.from(staffSelect.options).slice(1); // Skip placeholder

                    function resetSlots() {
                        slotsContainer.innerHTML = '<p class="text-sm text-gray-400 col-span-3 text-center py-4">Select a stylist and date first.</p>';
                        timeInput.value = '';
                        slotError.classList.add('hidden');
                    }

                    async function fetchSlots() {
                        const date = dateInput.value;
                        const staffId = staffSelect.value;
                        const serviceId = serviceSelect.value;

                        if (!date || !staffId || !serviceId) {
                            resetSlots();
                            return;
                        }

                        slotsContainer.classList.add('hidden');
                        slotsLoading.classList.remove('hidden');
                        slotError.classList.add('hidden');

                        try {
                            const response = await fetch(`{{ route('api.slots') }}?date=${date}&staff_id=${staffId}&service_id=${serviceId}`);
                            const data = await response.json();

                            slotsLoading.classList.add('hidden');
                            slotsContainer.classList.remove('hidden');
                            slotsContainer.innerHTML = '';

                            if (data.slots && data.slots.length > 0) {
                                data.slots.forEach(slot => {
                                    const btn = document.createElement('button');
                                    btn.type = 'button';
                                    btn.className = 'py-2 px-3 rounded-lg border border-gray-200 text-sm font-medium hover:border-purple-500 hover:bg-purple-50 focus:bg-purple-600 focus:text-white focus:border-purple-600 transition';
                                    btn.textContent = slot; // Format like 10:00
                                    
                                    btn.addEventListener('click', function() {
                                        // Reset other buttons
                                        slotsContainer.querySelectorAll('button').forEach(b => {
                                            b.classList.remove('bg-purple-600', 'text-white', 'border-purple-600');
                                            b.classList.add('hover:bg-purple-50', 'text-gray-800', 'border-gray-200');
                                        });
                                        
                                        // Highlight this button
                                        this.classList.remove('hover:bg-purple-50', 'text-gray-800', 'border-gray-200');
                                        this.classList.add('bg-purple-600', 'text-white', 'border-purple-600');
                                        
                                        // Set input value
                                        timeInput.value = slot;
                                    });

                                    slotsContainer.appendChild(btn);
                                });
                            } else {
                                slotsContainer.innerHTML = '<p class="text-sm text-red-400 col-span-3 text-center py-4">No slots available for this date.</p>';
                            }

                        } catch (error) {
                            console.error('Error fetching slots:', error);
                            slotsLoading.classList.add('hidden');
                            slotError.textContent = 'Failed to load slots. Please try again.';
                            slotError.classList.remove('hidden');
                        }
                    }

                    branchSelect.addEventListener('change', function() {
                        const branchId = this.value;
                        
                        // Reset and Disable/Enable Dropdowns
                        serviceSelect.innerHTML = '<option value="">-- Choose a Service --</option>';
                        staffSelect.innerHTML = '<option value="">-- Choose a Stylist --</option>';
                        priceDisplay.textContent = ''; // Reset price
                        dateInput.disabled = true; // Disable date initially
                        dateInput.value = ''; // Reset date
                        resetSlots(); // Reset slots
                        
                        if (branchId) {
                            serviceSelect.disabled = false;
                            staffSelect.disabled = false;
                            dateInput.disabled = false; // Enable date

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
                            dateInput.disabled = true;
                        }
                    });

                    // Shared Logic for Price Calculation
                    function updatePricing() {
                        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                        const basePrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                        const redeemInput = document.getElementById('redeem_points');
                        const savingsDisplay = document.getElementById('savings-display');
                        const savingsAmount = document.getElementById('savings-amount');
                        
                        // Get current points
                        const points = redeemInput ? (parseInt(redeemInput.value) || 0) : 0;
                        const redeemValue = {{ \App\Models\Setting::getValue('loyalty_redeem_value', 10) }};
                        
                        let savings = points * redeemValue;
                        
                        // Cap savings at base price
                        if (savings > basePrice) {
                            savings = basePrice;
                        }

                        // Update Savings UI
                        if (redeemInput && savings > 0) {
                            savingsDisplay.classList.remove('hidden');
                            savingsAmount.textContent = savings;
                        } else if (redeemInput) {
                            savingsDisplay.classList.add('hidden');
                        }

                        // Update Button Price
                        if (basePrice > 0) {
                            const finalPrice = basePrice - savings;
                            priceDisplay.textContent = '(৳' + finalPrice.toFixed(2) + ')';
                            
                            // Visual cue if discounted
                            if (savings > 0) {
                                priceDisplay.classList.add('text-green-200'); // Slight hint on button text if needed, or just keep it simple
                            } else {
                                priceDisplay.classList.remove('text-green-200');
                            }
                        } else {
                            priceDisplay.textContent = '';
                        }
                    }

                    // Trigger Slot Fetching Logic & Pricing
                    dateInput.addEventListener('change', fetchSlots);
                    staffSelect.addEventListener('change', fetchSlots);
                    serviceSelect.addEventListener('change', function() {
                        updatePricing();
                        // Also fetch slots if date and staff are selected
                        if (dateInput.value && staffSelect.value) {
                            fetchSlots();
                        }
                    });

                    // Hook into redeem input from the other script block if it exists
                    // Since that input is in the DOM, let's add a global listener or merge the logic.
                    // The previous script block for redeem_points handled its own 'input' event. 
                    // To avoid conflicts or duplication, let's attach the listener here if the element exists,
                    // as this script block has access to 'serviceSelect' which is needed for base price.
                    const redeemPointsInput = document.getElementById('redeem_points');
                    if (redeemPointsInput) {
                        redeemPointsInput.addEventListener('input', updatePricing);
                    }
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
