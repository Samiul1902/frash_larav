<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Style') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 mb-4">
                    Create Style
                </h1>
                <p class="text-gray-600 text-lg">Transform text or images into stunning visual styles powered by AI.</p>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-2xl overflow-hidden border border-white/50 p-8">
                <form action="{{ route('ai.image.generate') }}" method="POST" enctype="multipart/form-data" class="mb-8 space-y-6">
                    @csrf
                    
                    <!-- Text Prompt -->
                    <div>
                        <label for="prompt" class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wide">Describe your vision</label>
                        <textarea name="prompt" id="prompt" rows="3" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-purple-500 focus:bg-white focus:ring-2 focus:ring-purple-200 text-gray-700 transition duration-200 ease-in-out" placeholder="E.g., A futuristic cyberpunk salon with neon blue lights..." required>{{ $prompt ?? '' }}</textarea>
                    </div>

                    <!-- Image Upload (Optional) -->
                    <div>
                        <label for="image_file" class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wide">Upload Reference Image (Optional)</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="image_file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG (MAX. 4MB)</p>
                                </div>
                                <input id="image_file" name="image_file" type="file" class="hidden" accept="image/*" onchange="document.getElementById('file-name').innerText = this.files[0].name" />
                            </label>
                        </div>
                        <p id="file-name" class="mt-2 text-sm text-gray-600 text-center font-medium"></p>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg transform transition hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        Generate Usage Style
                    </button>
                </form>

                @if(isset($image))
                    <div class="border-t border-gray-100 pt-8 animate-fade-in-up">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Your Creation</h3>
                        <div class="relative group">
                            <img src="data:image/png;base64,{{ $image }}" alt="Generated Image" class="mx-auto rounded-xl shadow-2xl max-w-full h-auto transition duration-300 group-hover:scale-[1.01]">
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black/30 rounded-xl">
                                <a href="data:image/png;base64,{{ $image }}" download="create-style-image.png" class="bg-white text-gray-900 font-bold py-2 px-6 rounded-full shadow-lg hover:bg-gray-100 transform hover:scale-105 transition">
                                    Download HD
                                </a>
                            </div>
                        </div>
                        @if(isset($refined_prompt))
                            <div class="mt-4 p-4 bg-gray-50 rounded text-xs text-gray-500">
                                <span class="font-bold">AI Interpretation:</span> {{ Str::limit($refined_prompt, 200) }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
