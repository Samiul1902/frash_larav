<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reschedule Appointment') }}
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

                <form action="{{ route('appointments.update', $appointment->id) }}" method="POST" id="booking-form" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Service & Staff -->
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Current Appointment</h3>
                            
                            <!-- Static Info -->
                             <div class="mb-4">
                                <label class="block text-gray-500 text-xs uppercase tracking-wide font-bold mb-1">Service</label>
                                <p class="text-gray-900 font-bold text-lg">{{ $appointment->service->title }}</p>
                            </div>

                             <div class="mb-4">
                                <label class="block text-gray-600 text-sm font-bold mb-2">Change Stylist (Optional)</label>
                                <select name="staff_id" id="staff_id" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                                    @foreach($staff->where('branch_id', $appointment->service->branch_id) as $member)
                                        <option value="{{ $member->id }}" {{ $member->id == $appointment->staff_id ? 'selected' : '' }}>
                                            {{ $member->name }} ({{ $member->specialization }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Date & Time -->
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">New Date & Time</h3>
                            
                            <div class="mb-4">
                                <label class="block text-gray-600 text-sm font-bold mb-2">Date</label>
                                <input type="date" id="appointment_date" name="appointment_date" 
                                    class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 transition" 
                                    required min="{{ date('Y-m-d') }}" value="{{ $appointment->start_time->format('Y-m-d') }}">
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
                                    <p class="text-sm text-gray-400 col-span-3 text-center py-4">Loading slots...</p>
                                </div>
                                <input type="hidden" name="appointment_time" id="appointment_time" required value="{{ $appointment->start_time->format('H:i') }}">
                                <div id="slot-error" class="hidden text-red-500 text-xs mt-2 text-center"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t border-gray-100 pt-6 space-x-4">
                        <a href="{{ route('appointments.index') }}" class="text-gray-500 hover:text-gray-700 font-medium px-4">Cancel</a>
                        <button class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition hover:scale-105" type="submit">
                            Confirm Reschedule
                        </button>
                    </div>
                </form>

                <script>
                    const staffSelect = document.getElementById('staff_id');
                    const dateInput = document.getElementById('appointment_date');
                    const timeInput = document.getElementById('appointment_time');
                    const slotsContainer = document.getElementById('slots-container');
                    const slotsLoading = document.getElementById('slots-loading');
                    const slotError = document.getElementById('slot-error');
                    
                    const serviceId = {{ $appointment->service_id }};
                    const currentStaffId = {{ $appointment->staff_id }};
                    const currentSlot = "{{ $appointment->start_time->format('H:i') }}";
                    const currentDate = "{{ $appointment->start_time->format('Y-m-d') }}";

                    function resetSlots() {
                        slotsContainer.innerHTML = '<p class="text-sm text-gray-400 col-span-3 text-center py-4">Select a stylist and date first.</p>';
                        timeInput.value = '';
                        slotError.classList.add('hidden');
                    }

                    async function fetchSlots() {
                        const date = dateInput.value;
                        const staffId = staffSelect.value;
                        
                        if (!date || !staffId) {
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
                                // If current date and confirmed, ensure current slot is visible even if API marks it taken (by us)
                                // Actually API logic typically checks DB. If we are editing, our own appointment takes up the slot.
                                // Ideal API should allow excluding own appointment ID, but for now let's just see. 
                                // Or we just rely on API returning available slots. If we are rescheduling to same time, it's silly but valid.
                                
                                data.slots.forEach(slot => {
                                    const btn = document.createElement('button');
                                    btn.type = 'button';
                                    const isSelected = (slot === currentSlot && date === currentDate);
                                    
                                    btn.className = `py-2 px-3 rounded-lg border text-sm font-medium transition ${
                                        isSelected 
                                        ? 'bg-purple-600 text-white border-purple-600' 
                                        : 'border-gray-200 text-gray-800 hover:border-purple-500 hover:bg-purple-50'
                                    }`;
                                    btn.textContent = slot;
                                    
                                    btn.addEventListener('click', function() {
                                        slotsContainer.querySelectorAll('button').forEach(b => {
                                            b.classList.remove('bg-purple-600', 'text-white', 'border-purple-600');
                                            b.classList.add('hover:bg-purple-50', 'text-gray-800', 'border-gray-200');
                                        });
                                        
                                        this.classList.remove('hover:bg-purple-50', 'text-gray-800', 'border-gray-200');
                                        this.classList.add('bg-purple-600', 'text-white', 'border-purple-600');
                                        
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
                            slotError.textContent = 'Failed to load slots.';
                            slotError.classList.remove('hidden');
                        }
                    }

                    dateInput.addEventListener('change', fetchSlots);
                    staffSelect.addEventListener('change', fetchSlots);
                    
                    // Initial load
                    fetchSlots();
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
