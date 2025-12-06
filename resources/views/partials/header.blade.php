<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Smart Salon') }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 font-sans leading-normal tracking-normal flex flex-col min-h-screen">

<nav class="bg-white shadow-lg">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between">
            <div class="flex space-x-7">
                <div>
                    <!-- Website Logo -->
                    <a href="{{ url('/') }}" class="flex items-center py-4 px-2">
                        <span class="font-semibold text-gray-500 text-lg">Smart Salon</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ url('/') }}" class="py-4 px-2 font-semibold transition duration-300 {{ request()->is('/') ? 'text-blue-500 border-b-4 border-blue-500' : 'text-gray-500 hover:text-blue-500' }}">Home</a>
                    <a href="{{ route('services.index') }}" class="py-4 px-2 font-semibold transition duration-300 {{ request()->routeIs('services.*') ? 'text-blue-500 border-b-4 border-blue-500' : 'text-gray-500 hover:text-blue-500' }}">Services</a>
                    <a href="{{ route('about') }}" class="py-4 px-2 font-semibold transition duration-300 {{ request()->routeIs('about') ? 'text-blue-500 border-b-4 border-blue-500' : 'text-gray-500 hover:text-blue-500' }}">About</a>
                    <a href="{{ route('contact') }}" class="py-4 px-2 font-semibold transition duration-300 {{ request()->routeIs('contact') ? 'text-blue-500 border-b-4 border-blue-500' : 'text-gray-500 hover:text-blue-500' }}">Contact</a>
                    <a href="{{ route('ai.image.index') }}" class="py-4 px-2 font-bold text-pink-600 hover:text-pink-800 transition duration-300">Create Style</a>
                </div>
            </div>
            <!-- Secondary Navbar items -->
            <div class="hidden md:flex items-center space-x-3 ">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="py-2 px-2 font-medium text-gray-500 rounded hover:bg-green-500 hover:text-white transition duration-300">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="py-2 px-2 font-medium text-gray-500 rounded hover:bg-green-500 hover:text-white transition duration-300">Log In</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="py-2 px-2 font-medium text-white bg-green-500 rounded hover:bg-green-400 transition duration-300">Sign Up</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>

<div class="flex-grow">
