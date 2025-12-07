@extends('layouts.public')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="pt-32 pb-20 lg:pt-48 lg:pb-32 hero-pattern relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-purple-100 text-purple-600 text-sm font-bold mb-6 tracking-wide uppercase">
                Premium Salon Experience
            </span>
            <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 mb-8 leading-tight">
                Reveal Your Inner <br> <span class="bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-500">Radiance & Style</span>
            </h1>
            <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                Book top-tier salon services with ease. From haircuts to spa treatments, redefine your beauty journey with Smart Salon.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-gray-900 text-white rounded-full font-bold text-lg hover:bg-gray-800 transition transform hover:scale-105 shadow-xl">
                    Book an Appointment
                </a>
                <a href="{{ route('services.index') }}" class="px-8 py-4 bg-white text-gray-900 border border-gray-200 rounded-full font-bold text-lg hover:bg-gray-50 transition transform hover:scale-105 shadow-sm">
                    View Services
                </a>
            </div>
        </div>
        <!-- Decorative Blur Blobs -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 translate-x-1/2 translate-y-1/2"></div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Featured Services</h2>
                <p class="text-gray-500 max-w-xl mx-auto">Discover our most popular treatments designed to help you look and feel your absolute best.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featured_services as $service)
                <div class="group bg-gray-50 rounded-2xl p-4 transition hover:shadow-xl hover:-translate-y-1 duration-300 border border-gray-100">
                    <div class="h-48 rounded-xl overflow-hidden mb-4 relative">
                        @if($service->image)
                             <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                <span class="text-gray-400 font-medium">No Image</span>
                            </div>
                        @endif
                         <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-1 rounded-md text-xs font-bold text-gray-900">
                            {{ $service->duration_minutes }} min
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition">{{ $service->title }}</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2 h-10">{{ $service->description }}</p>
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-lg font-bold text-gray-900">৳{{ $service->price }}</span>
                        <a href="{{ route('services.index') }}" class="text-sm font-bold text-purple-600 hover:text-purple-800 transition">Book Now →</a>
                    </div>
                </div>
                @endforeach
            </div>
            
             <div class="text-center mt-12">
                <a href="{{ route('services.index') }}" class="inline-flex items-center font-bold text-purple-600 hover:text-purple-800 transition border-b-2 border-purple-200 hover:border-purple-600 pb-0.5">
                    View All Services <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us / About -->
    <section id="about" class="py-20 bg-gray-900 text-white relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                     <span class="text-purple-400 font-bold tracking-wider uppercase text-sm mb-2 block">Why Choose Smart Salon?</span>
                    <h2 class="text-3xl md:text-5xl font-bold mb-6">Excellence in Every Detail</h2>
                    <p class="text-gray-400 text-lg mb-8">
                        We combine expert stylists, premium products, and a relaxing atmosphere to deliver a salon experience like no other.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-gray-800 p-3 rounded-lg text-purple-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-xl font-bold mb-1">Expert Stylists</h4>
                                <p class="text-gray-400 text-sm">Highly trained professionals dedicated to perfection.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-gray-800 p-3 rounded-lg text-pink-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-xl font-bold mb-1">Online Booking</h4>
                                <p class="text-gray-400 text-sm">Book 24/7 with our seamless real-time scheduling system.</p>
                            </div>
                        </div>
                         <div class="flex items-start">
                            <div class="flex-shrink-0 bg-gray-800 p-3 rounded-lg text-blue-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-xl font-bold mb-1">Customer Satisfaction</h4>
                                <p class="text-gray-400 text-sm">Rated 5 stars by hundreds of happy clients.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                     <!-- Abstract Decoration -->
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl transform rotate-3 scale-105 opacity-50 blur-lg"></div>
                    <div class="bg-gray-800 rounded-2xl p-8 relative border border-gray-700">
                         <h3 class="text-2xl font-bold mb-6 text-center">Our Commitment</h3>
                         <div class="grid grid-cols-2 gap-4 text-center">
                             <div class="bg-gray-700/50 p-6 rounded-xl">
                                 <span class="block text-4xl font-bold text-white mb-2">5+</span>
                                 <span class="text-gray-400 text-xs uppercase tracking-wide">Years Experience</span>
                             </div>
                             <div class="bg-gray-700/50 p-6 rounded-xl">
                                 <span class="block text-4xl font-bold text-white mb-2">2k+</span>
                                 <span class="text-gray-400 text-xs uppercase tracking-wide">Happy Clients</span>
                             </div>
                             <div class="bg-gray-700/50 p-6 rounded-xl">
                                 <span class="block text-4xl font-bold text-white mb-2">100%</span>
                                 <span class="text-gray-400 text-xs uppercase tracking-wide">Quality Products</span>
                             </div>
                             <div class="bg-gray-700/50 p-6 rounded-xl">
                                 <span class="block text-4xl font-bold text-white mb-2">{{ $branches->count() }}</span>
                                 <span class="text-gray-400 text-xs uppercase tracking-wide">Locations</span>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="reviews" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">What Our Clients Say</h2>
                <p class="text-gray-500 max-w-xl mx-auto">Real stories from our valued customers.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($reviews as $review)
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center mb-4">
                         <div class="flex text-yellow-400">
                            @for($i=0; $i<$review->rating; $i++)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6 italic">"{{ $review->comment }}"</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-bold text-sm">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <h5 class="font-bold text-gray-900 text-sm">{{ $review->user->name }}</h5>
                            <span class="text-gray-400 text-xs">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
