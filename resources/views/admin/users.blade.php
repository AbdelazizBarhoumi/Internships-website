<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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

                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Name</th>
                                <th class="py-2 px-4 border-b">Email</th>
                                <th class="py-2 px-4 border-b">Role</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border-b">
                                        @if ($user->admin)
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                                {{ $user->admin->role }}
                                            </span>
                                        @elseif ($user->employer)
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                                                Employer
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">
                                                Regular User
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        @if ($user->admin)
                                            @if (auth()->id() !== $user->id)
                                                <form action="{{ route('admin.demote', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                                        Remove Admin
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            @if ($user->employer)
                                                <!-- Button trigger modal -->
                                                <button type="button" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm" 
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
                                                    <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                                        Promote to Admin
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
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