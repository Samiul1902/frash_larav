@include('partials.header')

<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800">Our Services</h1>
        <p class="text-gray-600 mt-2">Choose the best service for you.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($services as $service)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $service->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($service->description, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-2xl font-bold text-blue-600">${{ $service->price }}</span>
                            <span class="text-sm text-gray-500 block">{{ $service->duration_minutes }} mins</span>
                        </div>
                        <a href="{{ route('appointments.create') }}?service_id={{ $service->id }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@include('partials.footer')
