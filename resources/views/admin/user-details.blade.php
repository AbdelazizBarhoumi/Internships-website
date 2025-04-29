<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Profile: {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users') }}" class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm">
                &larr; Back to Users
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
            
            <!-- User Profile Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3 mb-4 md:mb-0">
                            <div class="text-center">
                                <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto flex items-center justify-center text-3xl text-gray-600">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <h3 class="text-lg font-bold">{{ $user->name }}</h3>
                                <p class="text-gray-600">{{ $user->email }}</p>
                                
                                <div class="mt-2">
                                    @if ($user->admin)
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">
                                            {{ ucfirst($user->admin->role) }}
                                        </span>
                                    @elseif ($user->employer)
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">
                                            Employer
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">
                                            Regular User
                                        </span>
                                    @endif
                                    
                                    @if($user->is_active)
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm ml-2">Active</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm ml-2">Suspended</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:w-2/3 md:pl-8 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-8">
                            <h3 class="text-lg font-semibold mb-4">Account Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Member Since</p>
                                    <p>{{ $user->created_at->format('F j, Y') }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500">Last Updated</p>
                                    <p>{{ $user->updated_at->format('F j, Y') }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500">Email Verified</p>
                                    <p>
                                        @if($user->email_verified_at)
                                            <span class="text-green-600">
                                                <i class="fas fa-check-circle mr-1"></i> 
                                                {{ $user->email_verified_at->format('F j, Y') }}
                                            </span>
                                        @else
                                            <span class="text-red-600">
                                                <i class="fas fa-times-circle mr-1"></i> Not verified
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex flex-wrap gap-2">
                                @if ($user->admin)
                                    @if (auth()->id() !== $user->id)
                                        <form action="{{ route('admin.demote', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                                <i class="fas fa-user-minus mr-1"></i> Remove Admin Role
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    @if ($user->employer)
                                        <!-- Button trigger modal -->
                                        <button type="button" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm"
                                                data-bs-toggle="modal" data-bs-target="#confirmModal">
                                            <i class="fas fa-user-shield mr-1"></i> Promote to Admin
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Warning: Role Change</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        This user is currently an employer. Promoting them to admin will remove their employer status. Continue?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="px-3 py-1 bg-gray-500 text-white rounded" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('admin.promote', $user) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                                                Confirm Promotion
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <form action="{{ route('admin.promote', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                                <i class="fas fa-user-shield mr-1"></i> Promote to Admin
                                            </button>
                                        </form>
                                    @endif
                                @endif
                                
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 {{ $user->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded text-sm">
                                            <i class="fas {{ $user->is_active ? 'fa-ban mr-1' : 'fa-check-circle mr-1' }}"></i>
                                            {{ $user->is_active ? 'Suspend Account' : 'Activate Account' }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User Specific Data -->
            @if($user->employer)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Employer Information</h3>
                        <div class="mb-4">
                            <p class="text-sm text-gray-500">Company</p>
                            <p class="font-medium">{{ $user->employer->company_name }}</p>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-sm text-gray-500">Industry</p>
                            <p>{{ $user->employer->industry }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Location</p>
                            <p>{{ $user->employer->location }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Employer's Internships -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Internships Posted</h3>
                        
                        @if(isset($userData['internships']) && count($userData['internships']) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="py-3 px-4 border-b text-left">Title</th>
                                            <th class="py-3 px-4 border-b text-left">Location</th>
                                            <th class="py-3 px-4 border-b text-left">Applications</th>
                                            <th class="py-3 px-4 border-b text-left">Status</th>
                                            <th class="py-3 px-4 border-b text-left">Posted</th>
                                            <th class="py-3 px-4 border-b text-left">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($userData['internships'] as $internship)
                                            <tr>
                                                <td class="py-3 px-4 border-b">{{ $internship->title }}</td>
                                                <td class="py-3 px-4 border-b">{{ $internship->location }}</td>
                                                <td class="py-3 px-4 border-b">{{ $internship->applications_count }}</td>
                                                <td class="py-3 px-4 border-b">
                                                    @if($internship->is_active)
                                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                                    @else
                                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-4 border-b">{{ $internship->created_at->format('M d, Y') }}</td>
                                                <td class="py-3 px-4 border-b">
                                                    <a href="{{ route('admin.internships.show', $internship) }}" class="text-blue-600 hover:underline">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">No internships posted by this employer.</p>
                        @endif
                    </div>
                </div>
            @elseif(!$user->admin)
                <!-- Regular User's Applications -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Applications Submitted</h3>
                        
                        @if(isset($userData['applications']) && count($userData['applications']) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="py-3 px-4 border-b text-left">Internship</th>
                                            <th class="py-3 px-4 border-b text-left">Employer</th>
                                            <th class="py-3 px-4 border-b text-left">Status</th>
                                            <th class="py-3 px-4 border-b text-left">Applied On</th>
                                            <th class="py-3 px-4 border-b text-left">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($userData['applications'] as $application)
                                            <tr>
                                                <td class="py-3 px-4 border-b">{{ $application->internship->title }}</td>
                                                <td class="py-3 px-4 border-b">{{ $application->internship->employer->company_name }}</td>
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
                                                    <a href="{{ route('admin.applications.show', $application) }}" class="text-blue-600 hover:underline">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">No applications submitted by this user.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Include Bootstrap JS for modals -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>