<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Add New Branch') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                <div class="p-10">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">Branch Details</h3>
                        <p class="text-gray-500 mt-1">Enter the information for the new salon branch.</p>
                    </div>

                    <form action="{{ route('admin.branches.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Name -->
                        <div>
                            <label class="block text-gray-600 font-medium mb-2" for="name">
                                Branch Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" 
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200" 
                                placeholder="e.g. Downtown Luxury Suite"
                                required>
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-gray-600 font-medium mb-2" for="address">
                                Address
                            </label>
                            <input type="text" name="address" id="address" 
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200"
                                placeholder="e.g. 123 Fashion Ave, New York">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-gray-600 font-medium mb-2" for="phone">
                                Phone Number
                            </label>
                            <input type="text" name="phone" id="phone" 
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200"
                                placeholder="e.g. +1 (555) 000-0000">
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.branches.index') }}" class="text-gray-500 hover:text-gray-800 font-medium transition-colors">Cancel</a>
                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition hover:scale-105 active:scale-95 duration-200">
                                Create Branch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
