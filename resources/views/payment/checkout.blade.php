<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Secure Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                <div class="md:flex">
                    <!-- Left: Summary -->
                    <div class="md:w-5/12 bg-gray-50 p-8 border-r border-gray-100">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Order Summary</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $appointment->service->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $appointment->service->duration_minutes }} mins</p>
                                </div>
                                <p class="font-bold text-gray-800">৳{{ $appointment->service->price }}</p>
                            </div>
                            
                            <hr class="border-gray-200">
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Stylist</p>
                                <p class="font-medium text-gray-800">{{ $appointment->staff->name }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600 mb-1">Date & Time</p>
                                <p class="font-medium text-gray-800">{{ $appointment->start_time->format('M d, Y') }} at {{ $appointment->start_time->format('h:i A') }}</p>
                            </div>

                            <hr class="border-gray-200">

                            <div class="flex justify-between items-center pt-2">
                                <p class="text-lg font-bold text-gray-800">Total</p>
                                <p class="text-2xl font-bold text-purple-600">৳{{ $appointment->service->price }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Payment Form -->
                    <div class="md:w-7/12 p-8 relative">
                        <!-- Spinner Overlay -->
                        <div id="loading-overlay" class="absolute inset-0 bg-white/80 z-10 hidden flex-col items-center justify-center">
                            <svg class="animate-spin h-10 w-10 text-purple-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-sm font-bold text-gray-600">Processing Payment...</p>
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Secure Payment</h3>
                        </div>

                        <!-- Payment Method Toggle -->
                        <div x-data="{ method: '{{ $clientSecret ? 'card' : 'sslcommerz' }}' }" class="space-y-6">
                            <div class="flex space-x-4 mb-6">
                                @if($clientSecret)
                                    <button @click="method = 'card'" :class="{'bg-purple-100 border-purple-500 text-purple-700': method === 'card', 'bg-white border-gray-200 text-gray-600': method !== 'card'}" class="flex-1 py-3 px-4 rounded-xl border-2 font-bold text-sm transition flex items-center justify-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                        <span>Card (Stripe)</span>
                                    </button>
                                @endif
                                <button @click="method = 'sslcommerz'" :class="{'bg-pink-100 border-pink-500 text-pink-700': method === 'sslcommerz', 'bg-white border-gray-200 text-gray-600': method !== 'sslcommerz'}" class="flex-1 py-3 px-4 rounded-xl border-2 font-bold text-sm transition flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>Mobile / Local</span>
                                </button>
                            </div>

                            <!-- Stripe Form -->
                            @if($clientSecret)
                                <div x-show="method === 'card'">
                                    <form id="payment-form">
                                        <div id="payment-element" class="mb-6 min-h-[200px]">
                                            <!-- Stripe.js will mount the elements here -->
                                        </div>
                                        
                                        <!-- Error Message -->
                                        <div id="error-message" class="hidden mb-6 bg-red-50 text-red-600 text-sm p-4 rounded-xl border border-red-100"></div>

                                        <button id="submit" class="w-full bg-black hover:bg-gray-800 text-white font-bold py-4 rounded-xl shadow-lg transform transition hover:scale-105 active:scale-95 duration-200 flex justify-between items-center px-6">
                                            <span id="button-text">Pay with Stripe</span>
                                            <span>৳{{ $appointment->service->price }}</span>
                                        </button>
                                    </form>
                                </div>
                            @endif

                            <!-- SSLCommerz Form -->
                            <div x-show="method === 'sslcommerz'" class="text-center">
                                <div class="bg-gradient-to-br from-pink-50 to-orange-50 p-6 rounded-2xl border border-pink-100 mb-6">
                                    <h4 class="font-bold text-gray-800 mb-2">Pay with SSLCommerz</h4>
                                    <p class="text-sm text-gray-600 mb-4">Supports bKash, Nagad, Rocket, Upay, Visa, MasterCard, and DBBL Nexus.</p>
                                    <div class="flex justify-center flex-wrap gap-2 opacity-70">
                                        <!-- Placeholder Icons -->
                                        <span class="px-2 py-1 bg-white border rounded text-xs">bKash</span>
                                        <span class="px-2 py-1 bg-white border rounded text-xs">Nagad</span>
                                        <span class="px-2 py-1 bg-white border rounded text-xs">Rocket</span>
                                        <span class="px-2 py-1 bg-white border rounded text-xs">VISA</span>
                                        <span class="px-2 py-1 bg-white border rounded text-xs">MasterCard</span>
                                    </div>
                                </div>

                                <form action="{{ route('payment.sslcommerz.pay', $appointment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-gradient-to-r from-pink-600 to-orange-500 hover:from-pink-700 hover:to-orange-600 text-white font-bold py-4 rounded-xl shadow-lg transform transition hover:scale-105 active:scale-95 duration-200 flex justify-between items-center px-6">
                                        <span>Proceed to Gateway</span>
                                        <span>৳{{ $appointment->service->price }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <p class="text-center text-xs text-gray-400 mt-4 flex items-center justify-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            SSL Encrypted & Secure
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stripe JS SDK (Only if keys exist) -->
    @if($clientSecret)
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            const stripe = Stripe("{{ $stripeKey }}");
            const clientSecret = "{{ $clientSecret }}";

            const appearance = {
                theme: 'stripe',
                variables: {
                    colorPrimary: '#9333ea', // Purple-600
                    colorBackground: '#f9fafb', // Gray-50
                    colorText: '#1f2937', // Gray-800
                    borderRadius: '12px',
                },
            };

            const elements = stripe.elements({ clientSecret, appearance });
            const paymentElement = elements.create("payment");
            paymentElement.mount("#payment-element");

            const form = document.getElementById("payment-form");
            const loadingOverlay = document.getElementById("loading-overlay");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                setLoading(true);

                const { error } = await stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        return_url: "{{ route('payment.success', ['appointment_id' => $appointment->id]) }}",
                    },
                });

                if (error) {
                    const messageContainer = document.querySelector('#error-message');
                    messageContainer.textContent = error.message;
                    messageContainer.classList.remove('hidden');
                    setLoading(false);
                } else {
                    // Your customer will be redirected to your `return_url`.
                }
            });

            function setLoading(isLoading) {
                if (isLoading) {
                    loadingOverlay.classList.remove('hidden');
                    loadingOverlay.classList.add('flex');
                } else {
                    loadingOverlay.classList.add('hidden');
                    loadingOverlay.classList.remove('flex');
                }
            }
        </script>
    @endif
</x-app-layout>
