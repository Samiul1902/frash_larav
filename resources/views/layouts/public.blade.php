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
<body class="antialiased bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- Sticky Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 glass border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600">
                        SmartSalon
                    </a>
                </div>
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ url('/#home') }}" class="text-gray-600 hover:text-purple-600 font-medium transition">Home</a>
                    <a href="{{ route('services.index') }}" class="text-gray-600 hover:text-purple-600 font-medium transition">Services</a>
                    <a href="{{ url('/#reviews') }}" class="text-gray-600 hover:text-purple-600 font-medium transition">Testimonials</a>
                    <a href="{{ url('/#contact') }}" class="text-gray-600 hover:text-purple-600 font-medium transition">Contact</a>
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
                    <a href="{{ url('/#home') }}" class="text-gray-600 font-medium">Home</a>
                    <a href="{{ route('services.index') }}" class="text-gray-600 font-medium">Services</a>
                    <a href="{{ url('/#reviews') }}" class="text-gray-600 font-medium">Testimonials</a>
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

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="contact" class="bg-white border-t border-gray-100 pt-20 pb-10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-1">
                    <a href="{{ url('/') }}" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600 mb-6 inline-block">
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
                         <li><a href="{{ route('services.index') }}" class="hover:text-purple-600 transition">Services</a></li>
                         <li><a href="{{ url('/#reviews') }}" class="hover:text-purple-600 transition">Testimonials</a></li>
                         <li><a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600 transition">Admin Login</a></li>
                     </ul>
                </div>

                 <!-- Locations -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="font-bold text-gray-900 mb-6">Our Locations</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @php
                            $branches = \App\Models\Branch::all();
                        @endphp
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
