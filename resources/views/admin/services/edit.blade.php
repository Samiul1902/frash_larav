<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Edit Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                <div class="p-10">
                    <div class="mb-8 border-b border-gray-100 pb-6">
                        <h3 class="text-2xl font-bold text-gray-800">Service Details</h3>
                        <p class="text-gray-500 mt-1">Update the service information.</p>
                    </div>

                    <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                            <!-- Left Column: Core Info -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Title -->
                                <div>
                                    <label class="block text-gray-600 font-medium mb-2" for="title">
                                        Service Title <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="title" id="title" value="{{ $service->title }}" 
                                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200" 
                                        required>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label class="block text-gray-600 font-medium mb-2" for="description">
                                        Description
                                    </label>
                                    <textarea name="description" id="description" rows="5" 
                                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200">{{ $service->description }}</textarea>
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
                                            <input type="number" name="price" id="price" step="0.01" value="{{ $service->price }}" 
                                                class="w-full pl-8 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200" 
                                                required>
                                        </div>
                                    </div>

                                    <!-- Duration -->
                                    <div>
                                        <label class="block text-gray-600 font-medium mb-2" for="duration_minutes">
                                            Duration (min) <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="number" name="duration_minutes" id="duration_minutes" value="{{ $service->duration_minutes }}" 
                                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200" 
                                                required>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span class="text-gray-400 sm:text-xs">min</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Media & Meta -->
                            <div class="space-y-6">
                                <!-- Image Upload -->
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                    <label class="block text-gray-700 font-bold mb-4">Service Image</label>
                                    
                                    <!-- Current Image Preview -->
                                    @if($service->image)
                                        <div class="mb-4">
                                            <img src="{{ asset('storage/' . $service->image) }}" alt="Current Image" class="w-full h-48 object-cover rounded-lg shadow-sm">
                                            <p class="text-xs text-gray-500 mt-2 text-center">Current Media</p>
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-center w-full">
                                        <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-50 transition-colors">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 4 2"/>
                                                </svg>
                                                <p class="text-xs text-gray-500"><span class="font-semibold">Click to upload</span> (Replace)</p>
                                            </div>
                                            <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                                        </label>
                                    </div>
                                </div>

                                <!-- Branch Assignment -->
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                    <label class="block text-gray-700 font-bold mb-4" for="branch_id">Branch</label>
                                    <select name="branch_id" id="branch_id" 
                                        class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3">
                                        <option value="">All Branches</option>
                                        @foreach(\App\Models\Branch::all() as $branch)
                                            <option value="{{ $branch->id }}" {{ $service->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-400 mt-2">Where is this service available?</p>
                                </div>

                                <!-- Active Status -->
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 flex items-center justify-between">
                                    <span class="text-gray-700 font-bold">Active Service</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $service->is_active ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100 mt-4">
                            <a href="{{ route('admin.services.index') }}" class="text-gray-500 hover:text-gray-800 font-medium transition-colors">Cancel</a>
                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition hover:scale-105 active:scale-95 duration-200">
                                Update Service
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
