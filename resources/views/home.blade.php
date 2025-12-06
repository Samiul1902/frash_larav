@include('partials.header')

<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome to Smart Salon</h1>
        <p class="text-lg text-gray-600 mb-8">Book your appointment with the best stylists in town.</p>
        
        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">Book Now</a>
    </div>

    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold mb-2">Expert Stylists</h3>
            <p class="text-gray-600">Our team consists of certified professionals dedicated to your look.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold mb-2">Premium Services</h3>
            <p class="text-gray-600">We use top-tier products to ensure the best care for your hair and skin.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold mb-2">Easy Booking</h3>
            <p class="text-gray-600">Book your appointment online in seconds, anytime, anywhere.</p>
        </div>
    </div>
</div>

@include('partials.footer')
