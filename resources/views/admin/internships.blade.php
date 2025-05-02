<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Internships') }}
            </h2>
            <span class="text-sm text-gray-600">Total: {{ $internships->total() }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md flex justify-between items-center" role="alert">
                    <div>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="text-green-700" onclick="this.parentElement.remove()">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Enhanced Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Filter Internships</h3>
                    
                    <form action="{{ route('admin.internships') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="employer_id" class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                            <select id="employer_id" name="employer_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Companies</option>
                                @foreach(\App\Models\Employer::orderBy('employer_name')->get() as $employer)
                                    <option value="{{ $employer->id }}" {{ request('employer_id') == $employer->id ? 'selected' : '' }}>
                                        {{ $employer->employer_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Title, location, skills...">
                        </div>

                        <div class="flex items-center mt-6">
    @if(request()->hasAny(['status', 'search', 'employer_id', 'application_status']))
        <a href="{{ route('admin.internships') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
            Clear Filters
        </a>
    @endif
    <button type="submit" class="ml-auto px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
        </svg>
        Apply Filters
    </button>
</div>
                    </form>
                </div>
            </div>

            <!-- Enhanced Internship List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Internships ({{ $internships->total() }})</h3>

                    </div>
                    
                    @if($internships->count() > 0)
                        <div class="overflow-x-auto border rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Posted</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Applications</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($internships as $internship)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex flex-col">
                                                    <a href="{{ route('admin.internships.show', $internship) }}" class="text-blue-600 hover:text-blue-900 font-medium" title="{{ $internship->title }}">
                                                        {{ \Illuminate\Support\Str::limit($internship->title, 10) }}
                                                    </a>
                                                    <span class="text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($internship->position, 10) }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('admin.users.show', $internship->employer->user) }}" class="text-gray-900 hover:text-blue-600" title="{{ $internship->employer->employer_name }}">
                                                    {{ \Illuminate\Support\Str::limit($internship->employer->employer_name, 10) }}  
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-center">
                                                {{ $internship->location }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-center">
                                                <span title="{{ $internship->created_at->format('F j, Y, g:i a') }}">
                                                    {{ $internship->created_at->format('M d, Y') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if ($internship->deadline_date)
                                                 @php 
                                                    $deadline = \Carbon\Carbon::parse($internship->deadline_date);
                                                    $daysLeft = now()->diffInDays($deadline);
                                                    $isPast = $deadline->isPast();
                                                @endphp
                                                
                                                <span class=" {{ $isPast ? 'text-red-600' : ($daysLeft <= 7 ? 'text-orange-600' : 'text-gray-500') }}">
                                                    {{ $deadline->format('M d, Y') }}
                                                </span>
                                                @endif
                                               
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    {{ $internship->applications_count }}
                                                
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex flex-col space-y-1">
                                                    @if($internship->is_active)
                                                        <span class="px-2 py-1 inline-flex text-xs leading-4 font-medium rounded-full bg-green-100 text-green-800">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-1 inline-flex text-xs leading-4 font-medium rounded-full bg-red-100 text-red-800">
                                                            Inactive
                                                        </span>
                                                    @endif
                                                    
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium ">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.internships.show', $internship) }}" class="text-blue-600 hover:underline">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6">
                            {{ $internships->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="bg-white p-6 text-center border rounded-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No internships found</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if(request()->hasAny(['status', 'search', 'employer_id', 'application_status']))
                                    Try adjusting your filters or search criteria.
                                    <a href="{{ route('admin.internships') }}" class="text-blue-600 hover:underline font-medium">Clear all filters</a>
                                @else
                                    No internships have been posted yet.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add client-side filtering enhancements if needed
        document.addEventListener('DOMContentLoaded', function() {
            // Optional: Add instant search and other interactive features
        });
    </script>
</x-app-layout>