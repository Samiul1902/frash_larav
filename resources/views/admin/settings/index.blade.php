<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Loyalty Program Configuration</h3>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

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

                    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6 max-w-xl">
                        @csrf
                        @method('POST')

                        <!-- Earn Rate -->
                        <div>
                            <label for="loyalty_earn_rate" class="block text-sm font-medium text-gray-700">Points Earned per Appointment</label>
                            <input type="number" name="loyalty_earn_rate" id="loyalty_earn_rate" value="{{ $earnRate }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                            <p class="mt-1 text-sm text-gray-500">Number of points a user receives after completing an appointment.</p>
                        </div>

                        <!-- Redeem Value -->
                        <div>
                            <label for="loyalty_redeem_value" class="block text-sm font-medium text-gray-700">Redemption Value (Tk per Point)</label>
                            <input type="number" step="0.1" name="loyalty_redeem_value" id="loyalty_redeem_value" value="{{ $redeemValue }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                            <p class="mt-1 text-sm text-gray-500">Monetary value of 1 loyalty point in BDT.</p>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
