<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Internship Applications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Filters -->
                    <div class="mb-6">
                        <form action="{{ route('admin.applications') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search..." 
                                    class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                            </div>
                            
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Filter
                            </button>
                            
                            @if(request('status') || request('search'))
                                <a href="{{ route('admin.applications') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                    Clear
                                </a>
                            @endif
                        </form>
                    </div>
                    
                    <!-- Applications Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left">Applicant</th>
                                    <th class="py-3 px-4 border-b text-left">Internship</th>
                                    <th class="py-3 px-4 border-b text-left">Company</th>
                                    <th class="py-3 px-4 border-b text-left">Status</th>
                                    <th class="py-3 px-4 border-b text-left">Applied Date</th>
                                    <th class="py-3 px-4 border-b text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $application)
                                    <tr>
                                        <td class="py-3 px-4 border-b">
                                            <a href="{{ route('admin.users.show', $application->user) }}" class="text-blue-600 hover:underline">
                                                {{ $application->user->name }}
                                            </a>
                                        </td>
                                        <td class="py-3 px-4 border-b">
                                            <a href="{{ route('admin.internships.show', $application->internship) }}" class="text-blue-600 hover:underline">
                                                {{ $application->internship->title }}
                                            </a>
                                        </td>
                                        <td class="py-3 px-4 border-b">
                                            {{ $application->internship->employer->company_name }}
                                        </td>
                                        <td class="py-3 px-4 border-b">
                                            <span class="px-2 py-1 rounded text-xs
                                                {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $application->status === 'reviewing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 border-b">{{ $application->created_at->format('M d, Y') }}</td>
                                        <td class="py-3 px-4 border-b">
                                            <a href="{{ route('admin.applications.show', $application) }}" class="text-blue-600 hover:underline">View Details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-500">No applications found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $applications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>