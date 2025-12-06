<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="md:flex">
                    <!-- Left Side: Service Details -->
                    <div class="w-full md:w-1/2 p-8 md:p-12">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Service Details</h3>
                        
                        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="title">Title</label>
                                    <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="e.g. Haircut & Styling" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="branch_id">Branch</label>
                                    <select name="branch_id" id="branch_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                                        <option value="">-- All Branches --</option>
                                        @foreach(\App\Models\Branch::all() as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="price">Price (৳)</label>
                                        <input type="number" name="price" id="price" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="0.00" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="duration_minutes">Duration (mins)</label>
                                        <input type="number" name="duration_minutes" id="duration_minutes" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="30" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="description">Description</label>
                                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" placeholder="Brief details about the service..."></textarea>
                                </div>
                            </div>
                    </div>

                    <!-- Right Side: Visuals -->
                    <div class="w-full md:w-1/2 bg-gradient-to-br from-purple-50 to-pink-50 p-8 md:p-12 flex flex-col justify-center items-center text-center">
                        <div class="mb-6">
                            <div class="w-48 h-48 bg-white rounded-2xl shadow-inner border-2 border-dashed border-purple-300 flex items-center justify-center overflow-hidden relative group">
                                <img id="preview-image" src="#" alt="Preview" class="w-full h-full object-cover hidden">
                                <div id="placeholder" class="text-purple-400">
                                    <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm font-medium">Upload Image</span>
                                </div>
                                <input type="file" name="image" id="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewFile()">
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Recommended: Square JPG/PNG</p>
                        </div>
                        
                        <div class="w-full">
                            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transform transition hover:scale-105">
                                Create Service
                            </button>
                            <a href="{{ route('admin.services.index') }}" class="block mt-4 text-gray-500 text-sm hover:underline">Cancel</a>
                        </div>
                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewFile() {
            const preview = document.getElementById('preview-image');
            const file = document.getElementById('image').files[0];
            const placeholder = document.getElementById('placeholder');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>
