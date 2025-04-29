<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Internships') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.internships') }}" method="GET" class="flex flex-wrap gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                   placeholder="Search internships...">
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Filter
                            </button>
                            @if(request()->hasAny(['status', 'search']))
                                <a href="{{ route('admin.internships') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Internship List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">All Internships ({{ $internships->total() }})</h3>
                    
                    @if($internships->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 border-b text-left">Title</th>
                                        <th class="py-3 px-4 border-b text-left">Company</th>
                                        <th class="py-3 px-4 border-b text-left">Location</th>
                                        <th class="py-3 px-4 border-b text-left">Posted</th>
                                        <th class="py-3 px-4 border-b text-left">Applications</th>
                                        <th class="py-3 px-4 border-b text-left">Status</th>
                                        <th class="py-3 px-4 border-b text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($internships as $internship)
                                        <tr>
                                            <td class="py-3 px-4 border-b">
                                                <a href="{{ route('admin.internships.show', $internship) }}" class="text-blue-600 hover:underline">
                                                    {{ $internship->title }}
                                                </a>
                                            </td>
                                            <td class="py-3 px-4 border-b">{{ $internship->employer->company_name }}</td>
                                            <td class="py-3 px-4 border-b">{{ $internship->location }}</td>
                                            <td class="py-3 px-4 border-b">{{ $internship->created_at->format('M d, Y') }}</td>
                                            <td class="py-3 px-4 border-b">{{ $internship->applications_count }}</td>
                                            <td class="py-3 px-4 border-b">
                                                @if($internship->is_active)
                                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                                @else
                                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 border-b">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.internships.show', $internship) }}" class="text-blue-600 hover:underline">View</a>
                                                    
                                                    <form action="{{ route('admin.internships.toggle-status', $internship) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-yellow-600 hover:underline ml-2">
                                                            {{ $internship->is_active ? 'Deactivate' : 'Activate' }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $internships->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No internships found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>