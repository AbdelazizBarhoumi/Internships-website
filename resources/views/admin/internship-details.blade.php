<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Internship Details
            </h2>
            <a href="{{ route('admin.internships') }}"
                class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm">
                &larr; Back to Internships
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Internship Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold">{{ $internship->title }}</h1>
                            <p class="text-gray-600 mt-1">
                                <span class="font-medium">{{ $internship->employer->company_name }}</span> •
                                {{ $internship->location }}
                            </p>
                        </div>
                        <div>
                            @if($internship->is_active)
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">Active</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">Inactive</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-semibold mb-2">Details</h3>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-gray-500">Duration:</span>
                                        <span>{{ $internship->duration }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Type:</span>
                                        <span>{{ $internship->type }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Posted:</span>
                                        <span>{{ $internship->created_at->format('F j, Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Applications:</span>
                                        <span>{{ $internship->applications->count() }}</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2">Tags</h3>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($internship->tags as $tag)
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                            {{ $tag->name }}
                                        </span>
                                    @empty
                                        <span class="text-gray-500">No tags</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-2">Description</h3>
                            <div class="prose max-w-none">
                                {!! nl2br(e($internship->description)) !!}
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-2">Requirements</h3>
                            <div class="prose max-w-none">
                                {!! nl2br(e($internship->requirements)) !!}
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-3 mt-8">
                        <form action="{{ route('admin.internships.toggle-status', $internship) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 {{ $internship->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded">
                                {{ $internship->is_active ? 'Deactivate Internship' : 'Activate Internship' }}
                            </button>
                        </form>

                        <button type="button" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
                            data-bs-toggle="modal" data-bs-target="#deleteModal">
                            Delete Internship
                        </button>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirm Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this internship? This action cannot be undone.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="px-3 py-1 bg-gray-500 text-white rounded"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('admin.internships.delete', $internship) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                                Delete Permanently
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Applications ({{ $internship->applications->count() }})</h3>

                    @if($internship->applications->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 border-b text-left">Applicant</th>
                                        <th class="py-3 px-4 border-b text-left">Status</th>
                                        <th class="py-3 px-4 border-b text-left">Applied On</th>
                                        <th class="py-3 px-4 border-b text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($internship->applications as $application)
                                        <tr>
                                            <td class="py-3 px-4 border-b">
                                                <a href="{{ route('admin.users.show', $application->user) }}"
                                                    class="text-blue-600 hover:underline">
                                                    {{ $application->user->name }}
                                                </a>
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
                                                <a href="{{ route('admin.applications.show', $application) }}"
                                                    class="text-blue-600 hover:underline">View Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No applications have been submitted for this internship yet.</p>
                    @endif
                </div>
            </div>

            <!-- Employer Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Employer Information</h3>

                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="md:w-1/2">
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Company</p>
                                <p class="font-medium">
                                    {{ $internship->employer->company_name }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Industry</p>
                                <p>{{ $internship->employer->industry }}</p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Location</p>
                                <p>{{ $internship->employer->location }}</p>
                            </div>
                        </div>

                        <div class="md:w-1/2">
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Contact Person</p>
                                <p>{{ $internship->employer->user->name }}</p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Email</p>
                                <p>{{ $internship->employer->user->email }}</p>
                            </div>

                            <div>
                                <a href="{{ route('admin.users.show', $internship->employer->user) }}"
                                    class="text-blue-600 hover:underline">
                                    View Employer Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS for modals -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>