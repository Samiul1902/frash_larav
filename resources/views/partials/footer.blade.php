</div> <!-- End Main Content Div -->

<footer class="bg-gray-800 text-white py-6 mt-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <span class="font-bold text-lg">Smart Salon</span>
                <p class="text-sm mt-1">Your beauty, our duty.</p>
            </div>
            <div class="flex space-x-4">
                <a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Terms of Service</a>
            </div>
        </div>
        <div class="text-center mt-4 text-gray-500 text-sm">
            &copy; {{ date('Y') }} Smart Salon. All rights reserved.
        </div>
    </div>
</footer>

<!-- AlpineJS for Chatbot Widget -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@include('partials.chatbot-widget')

</body>
</html>
