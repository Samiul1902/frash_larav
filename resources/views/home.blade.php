<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Smart Salon') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        .hero-pattern { background-image: radial-gradient(#e5e7eb 1px, transparent 1px); background-size: 24px 24px; }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <!-- Sticky Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 glass border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="#" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600">
                        SmartSalon
                    </a>
                </div>
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#home" class="text-gray-600 hover:text-purple-600 font-medium transition">Home</a>
                    <a href="#services" class="text-gray-600 hover:text-purple-600 font-medium transition">Services</a>
                    <a href="#reviews" class="text-gray-600 hover:text-purple-600 font-medium transition">Testimonials</a>
                    <a href="#contact" class="text-gray-600 hover:text-purple-600 font-medium transition">Contact</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-white bg-purple-600 hover:bg-purple-700 px-5 py-2 rounded-full font-medium transition shadow-lg shadow-purple-200">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-medium mr-4">Log in</a>
                            <a href="{{ route('register') }}" class="text-white bg-gray-900 hover:bg-gray-800 px-5 py-2 rounded-full font-medium transition">Sign Up</a>
                        @endauth
                    @endif
                </div>
                <!-- Mobile Menu Button -->
                 <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-600 hover:text-purple-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden glass absolute top-20 left-0 w-full p-6 border-b border-gray-100 shadow-xl">
                 <div class="flex flex-col space-y-4">
                    <a href="#home" class="text-gray-600 font-medium">Home</a>
                    <a href="#services" class="text-gray-600 font-medium">Services</a>
                    <a href="#reviews" class="text-gray-600 font-medium">Testimonials</a>
                     @auth
                        <a href="{{ url('/dashboard') }}" class="text-purple-600 font-bold">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 font-medium">Log in</a>
                        <a href="{{ route('register') }}" class="text-purple-600 font-bold">Sign Up</a>
                    @endauth
                 </div>
            </div>
        </div>
    </nav>

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
                <a href="{{ route('services.index') }}" class="px-8 py-4 bg-gray-900 text-white rounded-full font-bold text-lg hover:bg-gray-800 transition transform hover:scale-105 shadow-xl">
                    Book an Appointment
                </a>
                <a href="#services" class="px-8 py-4 bg-white text-gray-900 border border-gray-200 rounded-full font-bold text-lg hover:bg-gray-50 transition transform hover:scale-105 shadow-sm">
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

    <!-- Footer -->
    <footer id="contact" class="bg-white border-t border-gray-100 pt-20 pb-10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-1">
                    <a href="#" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600 mb-6 inline-block">
                        SmartSalon
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        Revolutionizing the salon experience with smart technology and premium care.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-purple-600 transition"><span class="sr-only">Facebook</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/></svg></a>
                        <a href="#" class="text-gray-400 hover:text-purple-600 transition"><span class="sr-only">Instagram</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465 1.067-.047 1.379-.06 3.808-.06h.63zm1.5.883H12c-2.29 0-2.53.01-3.6.048-1.096.04-1.697.17-2.096.325a3.91 3.91 0 00-1.417.923 3.91 3.91 0 00-.923 1.417c-.155.399-.285 1.001-.325 2.096-.039 1.07-.049 1.31-.049 3.6v.73c0 2.29.01 2.53.049 3.6.04 1.095.17 1.696.325 2.096.25.645.583 1.144 1.156 1.716.573.573 1.072.906 1.716 1.156.399.155.996.285 2.096.325 1.07.039 1.31.049 3.6.049h.73c2.29 0 2.53-.01 3.6-.049 1.095-.04 1.696-.17 2.096-.325a3.91 3.91 0 001.417-.923 3.91 3.91 0 00.923-1.417c.155-.399.285-1.001.325-2.096.039-1.07.049-1.31.049-3.6v-.73c0-2.29-.01-2.53-.049-3.6-.04-1.096-.17-1.697-.325-2.096a3.91 3.91 0 00-.923-1.417 3.91 3.91 0 00-1.417-.923c-.399-.155-1.001-.285-2.096-.325-1.07-.039-1.31-.049-3.6-.049h-.73zm0 3.833a5.283 5.283 0 110 10.566 5.283 5.283 0 010-10.566zm0 1.5a3.783 3.783 0 100 7.566 3.783 3.783 0 000-7.566zm6.83-8.083a1 1 0 110 2 1 1 0 010-2z" clip-rule="evenodd"/></svg></a>
                    </div>
                </div>

                 <!-- Quick Links -->
                <div>
                     <h3 class="font-bold text-gray-900 mb-6">Quick Links</h3>
                     <ul class="space-y-4 text-sm text-gray-500">
                         <li><a href="#services" class="hover:text-purple-600 transition">Services</a></li>
                         <li><a href="#reviews" class="hover:text-purple-600 transition">Testimonials</a></li>
                         <li><a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600 transition">Admin Login</a></li>
                     </ul>
                </div>

                 <!-- Locations -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="font-bold text-gray-900 mb-6">Our Locations</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($branches as $branch)
                        <div>
                            <h4 class="font-bold text-purple-600 text-sm">{{ $branch->name }}</h4>
                            <p class="text-gray-500 text-xs mt-1">{{ $branch->address }}</p>
                            @if($branch->phone)
                                <p class="text-gray-400 text-xs mt-1">{{ $branch->phone }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-100 pt-8 text-center">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Smart Salon. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Mobile Menu Toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
