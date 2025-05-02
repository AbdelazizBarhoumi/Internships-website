<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Management') }}
            </h2>
            <div class="mt-2 md:mt-0">
                <span class="text-sm text-gray-600">Total Users: <span
                        class="font-semibold">{{ $users->total() }}</span></span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alerts -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm"
                    role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('info'))
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 9a1 1 0 01-1-1v-4a1 1 0 112 0v4a1 1 0 01-1 1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('info') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 ">
                <div class="p-6">
                    <form action="{{ route('admin.users') }}" method="GET">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-end space-y-4 md:space-y-0 md:space-x-4">
                            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                                <div>
                                    <label for="filter" class="block text-sm font-medium text-gray-700">User Type</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <select id="filter" name="filter"
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                            <option value="">All Users</option>
                                            <option value="admins" {{ request('filter') == 'admins' ? 'selected' : '' }}>
                                                Admins</option>
                                            <option value="employers" {{ request('filter') == 'employers' ? 'selected' : '' }}>Employers</option>
                                            <option value="regular" {{ request('filter') == 'regular' ? 'selected' : '' }}>
                                                Regular Users</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                                            class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            placeholder="Name or email...">
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                               
                                <a href="{{ route('admin.users') }}"
                                    class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 {{ !request()->hasAny(['filter', 'search']) ? 'invisible' : '' }}">
                                    <span class="flex items-center">
                                        <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Clear
                                    </span>
                                </a>
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="flex items-center">
                                        <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                        </svg>
                                        Filter
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- User List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Users ({{ $users->total() }})</h3>
                        <div>
                            <span
                                class="text-sm text-gray-600">{{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }}
                                of {{ $users->total() }}</span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50 ">
                                <tr>
                                    <th
                                        class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        User</th>
                                    <th
                                        class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        Email</th>
                                    <th
                                        class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        Role</th>
                                    <th
                                        class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        Registered</th>
                                    <th
                                        class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        Status</th>
                                    <th
                                        class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <span
                                                            class="text-gray-500 font-medium">{{ substr($user->name, 0, 2) }}</span>
                                                </div>
                                                <div class="ml-4">
                                                    <a href="{{ route('admin.users.show', $user) }}"
                                                        class="text-sm font-medium text-blue-600 hover:text-blue-900 hover:underline">
                                                        {{ $user->name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $user->email }}
                                        </td>
                                        <td class="py-3 px-4 whitespace-nowrap text-center">
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
                                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-600">
                                            <div>{{ $user->created_at->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 whitespace-nowrap text-center">
                                            @if(!$user->isAdmin())
                                            @if(isset($user->is_active))
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    @if($user->is_active)
                                                        <svg class="mr-1 h-2 w-2 text-green-500" fill="currentColor"
                                                            viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3" />
                                                        </svg>
                                                    @else
                                                        <svg class="mr-1 h-2 w-2 text-red-500" fill="currentColor"
                                                            viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3" />
                                                        </svg>
                                                    @endif
                                                    {{ $user->is_active ? 'Active' : 'Suspended' }}
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="mr-1 h-2 w-2 text-green-500" fill="currentColor"
                                                        viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    Active
                                                </span>
                                            @endif
                                            @endif
                                            
                                        </td>
                                        <td class="py-3 px-4 whitespace-nowrap text-sm" x-data="{ 
                                                    openPromote: false,
                                                    openDemote: false,
                                                    openToggle: false 
                                                }">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.users.show', $user) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    View
                                                </a>

                                                @if (auth()->id() !== $user->id)
                                                    @if ($user->admin)
                                                        <!-- Demote Button -->
                                                        <button @click="openDemote = true" type="button"
                                                            class="text-yellow-600 hover:text-yellow-900 flex items-center">
                                                            <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                            </svg>
                                                            Demote
                                                        </button>

                                                        <!-- Demote Modal -->
                                                        <div x-show="openDemote" class="fixed z-10 inset-0 overflow-y-auto"
                                                            style="display: none;">
                                                            <div
                                                                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                                <div x-show="openDemote" x-transition:enter="ease-out duration-300"
                                                                    x-transition:enter-start="opacity-0"
                                                                    x-transition:enter-end="opacity-100"
                                                                    x-transition:leave="ease-in duration-200"
                                                                    x-transition:leave-start="opacity-100"
                                                                    x-transition:leave-end="opacity-0"
                                                                    class="fixed inset-0 transition-opacity" aria-hidden="true">
                                                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                                                </div>

                                                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                                                    aria-hidden="true">&#8203;</span>

                                                                <div x-show="openDemote" x-transition:enter="ease-out duration-300"
                                                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                                    x-transition:leave="ease-in duration-200"
                                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                        <div class="sm:flex sm:items-start">
                                                                            <div
                                                                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                                <svg class="h-6 w-6 text-yellow-600"
                                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round" stroke-width="2"
                                                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                                </svg>
                                                                            </div>
                                                                            <div
                                                                                class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                                <h3
                                                                                    class="text-lg leading-6 font-medium text-gray-900">
                                                                                    Remove Admin Rights</h3>
                                                                                <div class="mt-2">
                                                                                    <p class="text-sm text-gray-500 text-wrap">
                                                                                        Are you sure you want to demote
                                                                                        <strong>{{ $user->name }}</strong>? They
                                                                                        will lose all admin privileges.
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                        <form action="{{ route('admin.demote', $user) }}"
                                                                            method="POST" class="inline">
                                                                            @csrf
                                                                            <button type="submit"
                                                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                                Confirm Demotion
                                                                            </button>
                                                                        </form>
                                                                        <button @click="openDemote = false" type="button"
                                                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                            Cancel
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        @if ($user->employer)
                                                            <!-- Promote Button -->
                                                            <button @click="openPromote = true" type="button"
                                                                class="text-green-600 hover:text-green-900 flex items-center">
                                                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                                </svg>
                                                                Promote
                                                            </button>

                                                            <!-- Promote Modal -->
                                                            <div x-show="openPromote" class="fixed z-10 inset-0 overflow-y-auto"
                                                                style="display: none;">
                                                                <div
                                                                    class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                                    <div x-show="openPromote" x-transition:enter="ease-out duration-300"
                                                                        x-transition:enter-start="opacity-0"
                                                                        x-transition:enter-end="opacity-100"
                                                                        x-transition:leave="ease-in duration-200"
                                                                        x-transition:leave-start="opacity-100"
                                                                        x-transition:leave-end="opacity-0"
                                                                        class="fixed inset-0 transition-opacity" aria-hidden="true">
                                                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                                                    </div>

                                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                                                        aria-hidden="true">&#8203;</span>

                                                                    <div x-show="openPromote" x-transition:enter="ease-out duration-300"
                                                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                                        x-transition:leave="ease-in duration-200"
                                                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                            <div class="sm:flex sm:items-start">
                                                                                <div
                                                                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                                    <svg class="h-6 w-6 text-yellow-600"
                                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round"
                                                                                            stroke-linejoin="round" stroke-width="2"
                                                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                                    </svg>
                                                                                </div>
                                                                                <div
                                                                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                                    <h3
                                                                                        class="text-lg leading-6 font-medium text-gray-900">
                                                                                        Warning: Role Change</h3>
                                                                                    <div class="mt-2">
                                                                                        <p class="text-sm text-gray-500 text-wrap">
                                                                                            This user
                                                                                            (<strong>{{ $user->name }}</strong>) is
                                                                                            currently an employer. Promoting them to
                                                                                            admin will remove their employer status.
                                                                                            Continue?
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                            <form action="{{ route('admin.promote', $user) }}"
                                                                                method="POST" class="inline">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                                    Confirm Promotion
                                                                                </button>
                                                                            </form>
                                                                            <button @click="openPromote = false" type="button"
                                                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                                Cancel
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <!-- Promote Button -->
                                                            <button @click="openPromote = true" type="button"
                                                                class="text-green-600 hover:text-green-900 flex items-center">
                                                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                                </svg>
                                                                Promote
                                                            </button>

                                                            <!-- Regular User Promote Modal -->
                                                            <div x-show="openPromote" class="fixed z-10 inset-0 overflow-y-auto"
                                                                style="display: none;">
                                                                <div
                                                                    class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                                    <div x-show="openPromote" x-transition:enter="ease-out duration-300"
                                                                        x-transition:enter-start="opacity-0"
                                                                        x-transition:enter-end="opacity-100"
                                                                        x-transition:leave="ease-in duration-200"
                                                                        x-transition:leave-start="opacity-100"
                                                                        x-transition:leave-end="opacity-0"
                                                                        class="fixed inset-0 transition-opacity" aria-hidden="true">
                                                                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                                                    </div>

                                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                                                        aria-hidden="true">&#8203;</span>

                                                                    <div x-show="openPromote" x-transition:enter="ease-out duration-300"
                                                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                                        x-transition:leave="ease-in duration-200"
                                                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                            <div class="sm:flex sm:items-start">
                                                                                <div
                                                                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                                    <svg class="h-6 w-6 text-blue-600"
                                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round"
                                                                                            stroke-linejoin="round" stroke-width="2"
                                                                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                                                    </svg>
                                                                                </div>
                                                                                <div
                                                                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                                    <h3
                                                                                        class="text-lg leading-6 font-medium text-gray-900 ">
                                                                                        Promote to Admin</h3>
                                                                                    <div class="mt-2">
                                                                                        <p class="text-sm text-gray-500 text-wrap">
                                                                                            Are you sure you want to promote
                                                                                            <strong>{{ $user->name }}</strong> to admin?
                                                                                            They will gain access to all administrative
                                                                                            functions.
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                            <form action="{{ route('admin.promote', $user) }}"
                                                                                method="POST" class="inline">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                                    Confirm Promotion
                                                                                </button>
                                                                            </form>
                                                                            <button @click="openPromote = false" type="button"
                                                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                                Cancel
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <!-- Toggle Status Button -->
                                                        <button @click="openToggle = true" type="button"
                                                            class="text-red-600 hover:text-red-900 flex items-center">
                                                            @if(isset($user->is_active) && $user->is_active)
                                                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                                </svg>
                                                                Suspend
                                                            @else
                                                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                Activate
                                                            @endif
                                                        </button>

                                                        <!-- Toggle Status Modal -->
                                                        <div x-show="openToggle" class="fixed z-10 inset-0 overflow-y-auto"
                                                            style="display: none;">
                                                            <div
                                                                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                                <div x-show="openToggle" x-transition:enter="ease-out duration-300"
                                                                    x-transition:enter-start="opacity-0"
                                                                    x-transition:enter-end="opacity-100"
                                                                    x-transition:leave="ease-in duration-200"
                                                                    x-transition:leave-start="opacity-100"
                                                                    x-transition:leave-end="opacity-0"
                                                                    class="fixed inset-0 transition-opacity" aria-hidden="true">
                                                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                                                </div>

                                                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                                                    aria-hidden="true">&#8203;</span>

                                                                <div x-show="openToggle" x-transition:enter="ease-out duration-300"
                                                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                                    x-transition:leave="ease-in duration-200"
                                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                        <div class="sm:flex sm:items-start">
                                                                            <div
                                                                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full {{ isset($user->is_active) && $user->is_active ? 'bg-red-100' : 'bg-green-100' }} sm:mx-0 sm:h-10 sm:w-10">
                                                                                @if(isset($user->is_active) && $user->is_active)
                                                                                    <svg class="h-6 w-6 text-red-600"
                                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round"
                                                                                            stroke-linejoin="round" stroke-width="2"
                                                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                                    </svg>
                                                                                @else
                                                                                    <svg class="h-6 w-6 text-green-600"
                                                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round"
                                                                                            stroke-linejoin="round" stroke-width="2"
                                                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                                    </svg>
                                                                                @endif
                                                                            </div>
                                                                            <div
                                                                                class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                                <h3
                                                                                    class="text-lg leading-6 font-medium text-gray-900">
                                                                                    @if(isset($user->is_active) && $user->is_active)
                                                                                        Suspend User Account
                                                                                    @else
                                                                                        Activate User Account
                                                                                    @endif
                                                                                </h3>
                                                                                <div class="mt-2">
                                                                                    <p class="text-sm text-gray-500 text-wrap">
                                                                                        @if(isset($user->is_active) && $user->is_active)
                                                                                            Are you sure you want to suspend
                                                                                            <strong>{{ $user->name }}</strong>'s
                                                                                            account? They will no longer be able to log
                                                                                            in or use any platform features.
                                                                                        @else
                                                                                            Are you sure you want to activate
                                                                                            <strong>{{ $user->name }}</strong>'s
                                                                                            account? They will regain access to all
                                                                                            platform features.
                                                                                        @endif
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                        <form
                                                                            action="{{ route('admin.users.toggle-status', $user) }}"
                                                                            method="POST" class="inline">
                                                                            @csrf
                                                                            <button type="submit"
                                                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 {{ isset($user->is_active) && $user->is_active ? 'bg-red-600 hover:bg-red-700 focus:ring-red-500' : 'bg-green-600 hover:bg-green-700 focus:ring-green-500' }} text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                                                                                @if(isset($user->is_active) && $user->is_active)
                                                                                    Confirm Suspension
                                                                                @else
                                                                                    Confirm Activation
                                                                                @endif
                                                                            </button>
                                                                        </form>
                                                                        <button @click="openToggle = false" type="button"
                                                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                            Cancel
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Empty state -->
                    @if($users->count() === 0)
                        <div class="py-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
                            <p class="mt-1 text-sm text-gray-500">No users match your current filter settings.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.users') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Clear filters
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>