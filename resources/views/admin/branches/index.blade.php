<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Branches') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('admin.branches.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">
                    + Add New Branch
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <th class="px-5 py-3 ml-2">Name</th>
                            <th class="px-5 py-3">Address</th>
                            <th class="px-5 py-3">Phone</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($branches as $branch)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-5 text-sm font-medium text-gray-900">{{ $branch->name }}</td>
                                <td class="px-5 py-5 text-sm text-gray-500">{{ $branch->address ?? '-' }}</td>
                                <td class="px-5 py-5 text-sm text-gray-500">{{ $branch->phone ?? '-' }}</td>
                                <td class="px-5 py-5 text-sm text-right">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('admin.branches.edit', $branch->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Edit</a>
                                        <form action="{{ route('admin.branches.destroy', $branch->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
