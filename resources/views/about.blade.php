@include('partials.header')

<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">About Us</h1>
        <p class="text-gray-600 text-lg">
            Smart Salon is a premium salon management system designed to provide the best experience for our customers.
        </p>
        <p class="mt-4">
            We offer a wide range of services including haircuts, styling, coloring, and more. Our professional staff is dedicated to making you look and feel your best.
        </p>
    </div>

    <!-- Branches Section -->
    <div class="mt-16">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Our Branches</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($branches as $branch)
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $branch->name }}</h3>
                    <div class="text-gray-600 space-y-2">
                        @if($branch->address)
                            <p class="flex items-start">
                                <svg class="w-5 h-5 text-purple-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>{{ $branch->address }}</span>
                            </p>
                        @endif
                        @if($branch->phone)
                            <p class="flex items-center">
                                <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>{{ $branch->phone }}</span>
                            </p>
                        @endif
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Open Now
                        </span>
                        <a href="{{ route('services.index') }}" class="text-sm font-semibold text-purple-600 hover:text-purple-800">View Services →</a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500">
                    <p>We are currently operating online. Physical branches coming soon!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@include('partials.footer')
