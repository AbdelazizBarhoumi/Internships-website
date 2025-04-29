<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
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

            @if (session('info'))
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4" role="alert">
                    {{ session('info') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.users') }}" method="GET" class="flex flex-wrap gap-4">
                        <div>
                            <label for="filter" class="block text-sm font-medium text-gray-700">User Type</label>
                            <select id="filter" name="filter" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">All Users</option>
                                <option value="admins" {{ request('filter') == 'admins' ? 'selected' : '' }}>Admins</option>
                                <option value="employers" {{ request('filter') == 'employers' ? 'selected' : '' }}>Employers</option>
                                <option value="regular" {{ request('filter') == 'regular' ? 'selected' : '' }}>Regular Users</option>
                            </select>
                        </div>

                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                   placeholder="Name or email...">
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Filter
                            </button>
                            @if(request()->hasAny(['filter', 'search']))
                                <a href="{{ route('admin.users') }}" class="ml-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- User List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">All Users ({{ $users->total() }})</h3>
                    
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Role</th>
                                <th class="py-2 px-4 border-b">Registered</th>
                                <th class="py-2 px-4 border-b">Status</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:underline">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border-b">
                                        @if ($user->admin)
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                                {{ ucfirst($user->admin->role) }}
                                            </span>
                                        @elseif ($user->employer)
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                                                Employer
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">
                                                User
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="py-2 px-4 border-b">
                                        @if(isset($user->is_active))
                                            <span class="px-2 py-1 rounded-full text-xs {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $user->is_active ? 'Active' : 'Suspended' }}
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                                Active
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:underline">View</a>
                                            
                                            @if (auth()->id() !== $user->id)
                                                @if ($user->admin)
                                                    <form action="{{ route('admin.demote', $user) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-yellow-600 hover:underline ml-2">
                                                            Remove Admin
                                                        </button>
                                                    </form>
                                                @else
                                                    @if ($user->employer)
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="text-green-600 hover:underline ml-2" 
                                                                data-bs-toggle="modal" data-bs-target="#confirmModal{{ $user->id }}">
                                                            Promote to Admin
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="confirmModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
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
                                                                        <form action="{{ route('admin.promote', $user) }}" method="POST" class="inline">
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
                                                        <form action="{{ route('admin.promote', $user) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="text-green-600 hover:underline ml-2">
                                                                Promote to Admin
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-red-600 hover:underline ml-2">
                                                            {{ isset($user->is_active) && $user->is_active ? 'Suspend' : 'Activate' }}
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS for modals -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>