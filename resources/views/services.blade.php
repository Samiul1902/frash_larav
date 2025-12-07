@extends('layouts.public')

@section('content')
<div class="pt-32 pb-20 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">Our Services</h1>
            <p class="text-gray-500 max-w-xl mx-auto text-lg">Choose the best service for you.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100 flex flex-col">
                    <div class="h-56 rounded-xl overflow-hidden mb-6 relative">
                         @if($service->image)
                             <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                <span class="text-gray-400 font-medium">No Image</span>
                            </div>
                        @endif
                        @if($service->reviews->count() > 0)
                            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-1 rounded-md text-xs font-bold text-gray-900 flex items-center shadow-sm">
                                <span class="text-yellow-500 mr-1">&#9733;</span>
                                {{ number_format($service->reviews->avg('rating'), 1) }} <span class="text-gray-400 font-medium ml-1">({{ $service->reviews->count() }})</span>
                            </div>
                        @endif
                         <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-1 rounded-md text-xs font-bold text-gray-900 shadow-sm">
                            {{ $service->duration_minutes }} min
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition">{{ $service->title }}</h3>
                    <p class="text-gray-500 mb-6 flex-grow">{{ Str::limit($service->description, 100) }}</p>
                    
                    <div class="flex justify-between items-center pt-4 border-t border-gray-50 mt-auto">
                        <span class="text-2xl font-bold text-gray-900">৳{{ $service->price }}</span>
                        <a href="{{ route('appointments.create') }}?service_id={{ $service->id }}" class="bg-gray-900 hover:bg-purple-600 text-white font-bold py-3 px-6 rounded-full transition shadow-md hover:shadow-lg transform hover:scale-105">
                            Book Now
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
