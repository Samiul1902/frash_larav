@include('partials.header')

<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800">Smart Salon Assistant</h1>
        <p class="text-gray-600 mt-2">Ask me anything about our services, stylists, or booking availability!</p>
    </div>

    <div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-200">
        <!-- Chat Area -->
        <div id="chat-box" class="h-96 overflow-y-auto p-4 bg-gray-50 flex flex-col space-y-4">
            <!-- Initial Greeting -->
            <div class="flex items-start">
                <div class="bg-blue-100 text-blue-900 rounded-lg rounded-tl-none p-3 max-w-xs shadow-sm">
                    <p class="text-sm">Hi! I'm your virtual assistant. How can I help you today?</p>
                </div>
            </div>
            <!-- Messages will be appended here -->
        </div>

        <!-- Input Area -->
        <div class="border-t p-4 bg-white flex items-center">
            <input type="text" id="user-input" class="flex-grow border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your question..." onkeypress="handleEnter(event)">
            <button onclick="sendMessage()" class="ml-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg px-6 py-2 font-bold focus:outline-none transition duration-200">
                Send
            </button>
        </div>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    const userInput = document.getElementById('user-input');

    function handleEnter(e) {
        if (e.key === 'Enter') sendMessage();
    }

    async function sendMessage() {
        const message = userInput.value.trim();
        if (!message) return;

        // Add User Message
        appendMessage('user', message);
        userInput.value = '';
        
        // Show Loading
        const loadingId = appendLoading();

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
            
            // Remove Loading
            document.getElementById(loadingId).remove();

            if (data.response) {
                appendMessage('ai', data.response);
            } else {
                appendMessage('ai', "Sorry, something went wrong.");
            }

        } catch (error) {
            document.getElementById(loadingId).remove();
            appendMessage('ai', "Network error. Please try again.");
            console.error(error);
        }
    }

    function appendMessage(role, text) {
        const div = document.createElement('div');
        div.className = role === 'user' ? 'flex items-end justify-end' : 'flex items-start';
        
        const bubble = document.createElement('div');
        bubble.className = role === 'user' 
            ? 'bg-green-100 text-green-900 rounded-lg rounded-tr-none p-3 max-w-xs shadow-sm text-sm'
            : 'bg-blue-100 text-blue-900 rounded-lg rounded-tl-none p-3 max-w-xs shadow-sm text-sm';
        
        // Simple Markdown parsing for bold text
        bubble.innerHTML = text.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>').replace(/\n/g, '<br>');
        
        div.appendChild(bubble);
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function appendLoading() {
        const id = 'loading-' + Date.now();
        const div = document.createElement('div');
        div.id = id;
        div.className = 'flex items-start';
        div.innerHTML = `
            <div class="bg-gray-200 text-gray-500 rounded-lg rounded-tl-none p-3 shadow-sm text-xs italic">
                Result Generating...
            </div>
        `;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
        return id;
    }
</script>

@include('partials.footer')
