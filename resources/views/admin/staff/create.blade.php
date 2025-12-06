<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Add New Staff') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                <div class="p-10">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">Staff Details</h3>
                        <p class="text-gray-500 mt-1">Add a new team member to your salon.</p>
                    </div>

                    <form action="{{ route('admin.staff.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Name -->
                        <div>
                            <label class="block text-gray-600 font-medium mb-2" for="name">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" 
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200" 
                                placeholder="e.g. Sarah Johnson"
                                required>
                        </div>

                        <!-- Specialization -->
                        <div>
                            <label class="block text-gray-600 font-medium mb-2" for="specialization">
                                Specialization <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="specialization" id="specialization" 
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200" 
                                placeholder="e.g. Senior Hair Stylist"
                                required>
                        </div>

                        <!-- Bio -->
                        <div>
                            <label class="block text-gray-600 font-medium mb-2" for="bio">
                                Bio & Experience
                            </label>
                            <textarea name="bio" id="bio" rows="4" 
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200"
                                placeholder="Brief description of skills and experience..."></textarea>
                        </div>

                        <!-- Branch Assignment -->
                        <div>
                            <label class="block text-gray-600 font-medium mb-2" for="branch_id">
                                Assign Branch
                            </label>
                            <select name="branch_id" id="branch_id" 
                                class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block p-3 transition-colors duration-200">
                                <option value="">No Branch (Freelance/Roamiing)</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-400 mt-1">Select the primary location for this staff member.</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.staff.index') }}" class="text-gray-500 hover:text-gray-800 font-medium transition-colors">Cancel</a>
                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition hover:scale-105 active:scale-95 duration-200">
                                Add Staff Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
