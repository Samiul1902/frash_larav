<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Add New Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                <div class="md:flex">
                    <!-- Left Side: Service Details -->
                    <div class="w-full md:w-2/3 p-10">
                        <div class="mb-8 border-b border-gray-100 pb-6">
                            <h3 class="text-2xl font-bold text-gray-800">Service Details</h3>
                            <p class="text-gray-500 mt-1">Enter the details for the new service.</p>
                        </div>
                        
                        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <!-- Title -->
                            <div>
                                <label class="block text-gray-600 font-medium mb-2" for="title">
                                    Service Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" 
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200" 
                                    placeholder="e.g. Luxury Hair Spa"
                                    required>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-gray-600 font-medium mb-2" for="description">
                                    Description
                                </label>
                                <textarea name="description" id="description" rows="4" 
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200" 
                                    placeholder="Brief details about the service..."></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Price -->
                                <div>
                                    <label class="block text-gray-600 font-medium mb-2" for="price">
                                        Price (৳) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">৳</span>
                                        </div>
                                        <input type="number" name="price" id="price" step="0.01" 
                                            class="w-full pl-8 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200" 
                                            placeholder="0.00"
                                            required>
                                    </div>
                                </div>
                                
                                <!-- Duration -->
                                <div>
                                    <label class="block text-gray-600 font-medium mb-2" for="duration_minutes">
                                        Duration (min) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="duration_minutes" id="duration_minutes" 
                                            class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200" 
                                            placeholder="30"
                                            required>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 sm:text-xs">min</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Branch Assignment -->
                            <div>
                                <label class="block text-gray-600 font-medium mb-2" for="branch_id">
                                    Assign Branch
                                </label>
                                <select name="branch_id" id="branch_id" 
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200">
                                    <option value="">-- All Branches --</option>
                                    @foreach(\App\Models\Branch::all() as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                    </div>

                    <!-- Right Side: Visuals -->
                    <div class="w-full md:w-1/3 bg-gray-50 p-10 border-l border-gray-100 flex flex-col justify-center items-center text-center">
                        <div class="mb-6 w-full">
                            <label class="block text-gray-700 font-bold mb-4 text-left">Service Image</label>
                            
                            <label for="image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-white hover:bg-gray-50 transition-colors relative overflow-hidden group">
                                <div id="placeholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-12 h-12 mb-4 text-gray-400 group-hover:text-pink-500 transition-colors" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 4 2"/>
                                    </svg>
                                    <p class="text-sm text-gray-500 font-medium">Click to upload image</p>
                                    <p class="text-xs text-gray-400 mt-1">SVG, PNG, JPG (MAX. 2MB)</p>
                                </div>
                                <img id="preview-image" src="#" alt="Preview" class="absolute inset-0 w-full h-full object-cover hidden">
                                <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewFile()" />
                            </label>
                        </div>
                        
                        <div class="w-full mt-auto space-y-4">
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transform transition hover:scale-105 active:scale-95 duration-200">
                                Create Service
                            </button>
                            <a href="{{ route('admin.services.index') }}" class="block text-gray-500 text-sm hover:text-gray-800 font-medium transition-colors">Cancel</a>
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
                    placeholder.classList.add('opacity-0'); 
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>
