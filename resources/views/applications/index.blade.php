<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2 sm:mb-0">
                {{ isset($internship) ? "Applications for {$internship->title}" : "All Applications" }}
            </h2>

            <div class="flex items-center space-x-2">
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                
                <select id="status-filter"
                    class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Review</option>
                    <option value="reviewing" {{ request('status') == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                    <option value="interviewed" {{ request('status') == 'interviewed' ? 'selected' : '' }}>Interviewed</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>

                @unless(isset($internship))
                    <select id="internship-filter"
                        class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">All Internships</option>
                        @foreach($internships as $employerInternship)
                            <option value="{{ $employerInternship->id }}" {{ request('internship_id') == $employerInternship->id ? 'selected' : '' }}>
                                {{ $employerInternship->title }}
                            </option>
                        @endforeach
                    </select>
                @endunless
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Application Stats -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                    <p class="text-sm text-gray-500 uppercase tracking-wide">Total</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $applications->total() }}</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                    <p class="text-sm text-gray-500 uppercase tracking-wide">Pending</p>
                    <p class="text-2xl font-bold text-yellow-500">{{ $pendingCount ?? 0 }}</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                    <p class="text-sm text-gray-500 uppercase tracking-wide">Reviewing</p>
                    <p class="text-2xl font-bold text-blue-500">{{ $reviewingCount ?? 0 }}</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                    <p class="text-sm text-gray-500 uppercase tracking-wide">Interviewed</p>
                    <p class="text-2xl font-bold text-purple-500">{{ $interviewedCount ?? 0}}</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 text-center">
                    <p class="text-sm text-gray-500 uppercase tracking-wide">Accepted</p>
                    <p class="text-2xl font-bold text-green-500">{{ $acceptedCount ?? 0}}</p>
                </div>
            </div>

            <!-- Applications List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($applications->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Applicant</th>
                                        @unless(isset($internship))
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Internship</th>
                                        @endunless
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Education</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Applied</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            View</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Update Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($applications as $application)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $application->user->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                                                        @if($application->phone)
                                                            <div class="text-sm text-gray-500">{{ $application->phone }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            @unless(isset($internship))
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                    <strong><a href="{{ route('myinternship.show', $application->internship) }}" class="text-indigo-600 hover:text-indigo-900">{{ $application->internship->title }}</a></strong></div>
                                                </td>
                                            @endunless

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    @if($application->institution)
                                                        {{ $application->institution }}
                                                    @elseif($application->user->applicantProfile?->institution)
                                                        {{ $application->user->applicantProfile->institution }}
                                                    @else
                                                        Not specified
                                                    @endif
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    @if($application->education)
                                                        {{ ucfirst(str_replace('_', ' ', $application->education)) }}
                                                    @elseif($application->user->applicantProfile?->education_level)
                                                        {{ $application->user->applicantProfile->education_level }}
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">
                                                    {{ $application->created_at->format('M d, Y') }}
                                                </div>
                                                <div class="text-xs text-gray-400">
                                                    {{ $application->created_at->diffForHumans() }}
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                    @if($application->status == 'accepted') bg-green-100 text-green-800
                                                                    @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                                                    @elseif($application->status == 'interviewed') bg-purple-100 text-purple-800
                                                                    @elseif($application->status == 'reviewing') bg-blue-100 text-blue-800
                                                                    @else bg-yellow-100 text-yellow-800 @endif">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('applications.show', $application) }}"
                                                class="text-indigo-600 hover:text-indigo-900">View</a>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <form method="POST"
                                                    action="{{ route('applications.update-status', $application) }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    <!-- Status update dropdown -->
                                                    <select name="status" onchange="this.form.submit()"
                                                        class="text-xs border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                        <option value="">Change Status</option>
                                                        <option value="reviewing" {{ $application->status == 'reviewing' ? 'disabled' : '' }}>Mark as Reviewing</option>
                                                        <option value="interviewed" {{ $application->status == 'interviewed' ? 'disabled' : '' }}>Mark as Interviewed</option>
                                                        <option value="accepted" {{ $application->status == 'accepted' ? 'disabled' : '' }}>Accept</option>
                                                        <option value="rejected" {{ $application->status == 'rejected' ? 'disabled' : '' }}>Reject</option>
                                                    </select>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $applications->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No applications found</h3>
                            <p class="text-gray-500">No applications match your current filters.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        // Wait for DOM to fully load before attaching event listeners
        document.addEventListener('DOMContentLoaded', function () {
            // Safely get elements with error handling
            const statusFilter = document.getElementById('status-filter');
            const internshipFilter = document.getElementById('internship-filter');

            // Only attach event listeners if elements exist
            if (statusFilter) {
                statusFilter.addEventListener('change', applyFilters);
            }

            if (internshipFilter) {
                internshipFilter.addEventListener('change', applyFilters);
            }

            // Filter application function
            function applyFilters() {
                try {
                    let url = new URL(window.location);

                    // Handle status filter
                    if (statusFilter) {
                        if (statusFilter.value) {
                            url.searchParams.set('status', statusFilter.value);
                        } else {
                            url.searchParams.delete('status');
                        }
                    }

                    // Handle internship filter
                    if (internshipFilter) {
                        if (internshipFilter.value) {
                            url.searchParams.set('internship_id', internshipFilter.value);
                        } else {
                            url.searchParams.delete('internship_id');
                        }
                    }

                    // Navigate to filtered URL
                    window.location = url;
                } catch (e) {
                    console.error('Error applying filters:', e);
                }
            }
        });
    </script>
</x-app-layout>