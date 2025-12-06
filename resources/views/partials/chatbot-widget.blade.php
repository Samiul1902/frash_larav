<div x-data="{ open: false }" class="fixed bottom-6 right-6 z-50">
    <!-- Chat Window -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="bg-white rounded-2xl shadow-2xl w-80 sm:w-96 overflow-hidden border border-gray-100 mb-4 flex flex-col h-[500px]"
         style="display: none;">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-4 flex justify-between items-center text-white">
            <div class="flex items-center space-x-2">
                <span class="text-2xl">✨</span>
                <div>
                    <h3 class="font-bold text-sm">Smart Assistant</h3>
                    <p class="text-xs text-purple-100">Ask me anything!</p>
                </div>
            </div>
            <button @click="open = false" class="text-white hover:text-gray-200 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Messages -->
        <div id="widget-chat-box" class="flex-1 overflow-y-auto p-4 bg-gray-50 flex flex-col space-y-3">
            <div class="flex items-start">
                <div class="bg-blue-100 text-blue-900 rounded-lg rounded-tl-none p-3 max-w-[85%] text-sm shadow-sm">
                    Hi! I'm your AI assistant. How can I help you today?
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="p-3 bg-white border-t border-gray-100">
            <div class="flex items-center bg-gray-100 rounded-full px-4 py-2">
                <input type="text" id="widget-user-input" class="bg-transparent flex-grow text-sm focus:outline-none" placeholder="Type a message..." onkeypress="handleWidgetEnter(event)">
                <button onclick="sendWidgetMessage()" class="ml-2 text-purple-600 hover:text-purple-800 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Toggle Button (FAB) -->
    <button @click="open = !open" class="group flex items-center justify-center focus:outline-none transform hover:scale-110 transition duration-300 z-50">
        <img x-show="!open" src="{{ asset('images/c8c893c39689c135fc22ce83be448843_1763439606-removebg-preview.png') }}" class="w-20 h-20 drop-shadow-2xl animate-wiggle" alt="Chatbot">
        
        <div x-show="open" class="w-12 h-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full flex items-center justify-center shadow-lg" style="display: none;">
            <span class="text-xl text-white font-bold">✕</span>
        </div>
    </button>
</div>

<script>
    function handleWidgetEnter(e) {
        if (e.key === 'Enter') sendWidgetMessage();
    }

    async function sendWidgetMessage() {
        const input = document.getElementById('widget-user-input');
        const box = document.getElementById('widget-chat-box');
        const message = input.value.trim();
        if (!message) return;

        // User Message
        const userDiv = document.createElement('div');
        userDiv.className = 'flex items-end justify-end';
        userDiv.innerHTML = `<div class="bg-purple-100 text-purple-900 rounded-lg rounded-tr-none p-3 max-w-[85%] text-sm shadow-sm">${message}</div>`;
        box.appendChild(userDiv);
        box.scrollTop = box.scrollHeight;
        input.value = '';

        // Loading
        const loadingId = 'widget-loading-' + Date.now();
        const loadingDiv = document.createElement('div');
        loadingDiv.id = loadingId;
        loadingDiv.className = 'flex items-start';
        loadingDiv.innerHTML = `<div class="bg-gray-200 text-gray-500 rounded-lg rounded-tl-none p-3 text-xs italic shadow-sm">Thinking...</div>`;
        box.appendChild(loadingDiv);
        box.scrollTop = box.scrollHeight;

        try {
            const response = await fetch("{{ route('ai.message') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ message: message })
            });
            const data = await response.json();
            document.getElementById(loadingId).remove();

            const aiDiv = document.createElement('div');
            aiDiv.className = 'flex items-start';
            const cleanText = (data.response || "Error").replace(/\*\*(.*?)\*\*/g, '<b>$1</b>').replace(/\n/g, '<br>');
            aiDiv.innerHTML = `<div class="bg-blue-100 text-blue-900 rounded-lg rounded-tl-none p-3 max-w-[85%] text-sm shadow-sm">${cleanText}</div>`;
            box.appendChild(aiDiv);
            box.scrollTop = box.scrollHeight;

        } catch (error) {
            document.getElementById(loadingId).remove();
            console.error(error);
        }
    }
</script>
