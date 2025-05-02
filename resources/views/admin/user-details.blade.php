<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back button -->
            <div class="mb-6">
                <a href="{{ route('admin.users') }}"
                    class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Users
                </a>
            </div>

            <!-- User Profile Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="border-b border-gray-200">
                    <div class="px-6 py-4 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">User Profile</h2>

                        <!-- Action Buttons with Alpine.js for modals -->
                        <div class="flex space-x-2" x-data="{ 
                            openPromote: false,
                            openDemote: false,
                            openSuspend: false,
                            openActivate: false 
                        }">
                            @if (auth()->id() !== $user->id)
                                @if ($user->admin)
                                    <!-- Demote Button -->
                                    <button @click="openDemote = true" type="button"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        <svg class="h-3.5 w-3.5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                        Demote from Admin
                                    </button>

                                    <!-- Demote Confirmation Modal -->
                                    <div x-show="openDemote" class="fixed z-10 inset-0 overflow-y-auto" style="display: none;">
                                        <div
                                            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div x-show="openDemote" x-transition:enter="ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity"
                                                aria-hidden="true">
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
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                            </svg>
                                                        </div>
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                            <h3 class="text-lg leading-6 font-medium text-gray-900">Remove Admin
                                                                Rights</h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-500">
                                                                    Are you sure you want to demote
                                                                    <strong>{{ $user->name }}</strong>? They will lose all
                                                                    administrative privileges and access to the admin dashboard.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                    <form action="{{ route('admin.demote', $user) }}" method="POST"
                                                        class="inline">
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
                                    <!-- Promote Button -->
                                    <button @click="openPromote = true" type="button"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="h-3.5 w-3.5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7" />
                                        </svg>
                                        Promote to Admin
                                    </button>

                                    <!-- Promote Confirmation Modal -->
                                    <div x-show="openPromote" class="fixed z-10 inset-0 overflow-y-auto" style="display: none;">
                                        <div
                                            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div x-show="openPromote" x-transition:enter="ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity"
                                                aria-hidden="true">
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
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                            </svg>
                                                        </div>
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                                @if($user->employer)
                                                                    Warning: Role Change
                                                                @else
                                                                    Promote to Admin
                                                                @endif
                                                            </h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-500 text-wrap">
                                                                    @if($user->employer)
                                                                        This user (<strong>{{ $user->name }}</strong>) is currently
                                                                        an employer. Promoting them to admin will remove their
                                                                        employer status. Continue?
                                                                    @elseif($user->student)
                                                                        This user (<strong>{{ $user->name }}</strong>) is currently
                                                                        a student. Promoting them to admin will remove their student
                                                                        status. Continue?
                                                                    @else
                                                                        Are you sure you want to promote
                                                                        <strong>{{ $user->name }}</strong> to admin? They will gain
                                                                        full administrative privileges and access to the admin
                                                                        dashboard.
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                    <form action="{{ route('admin.promote', $user) }}" method="POST"
                                                        class="inline">
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

                                @if (!$user->admin)
                                    <!-- Toggle Status Button -->
                                    @if($user->is_active)
                                        <button @click="openSuspend = true" type="button"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="h-3.5 w-3.5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            Suspend Account
                                        </button>

                                        <!-- Suspend Confirmation Modal -->
                                        <div x-show="openSuspend" class="fixed z-10 inset-0 overflow-y-auto" style="display: none;">
                                            <div
                                                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                <div x-show="openSuspend" x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity"
                                                    aria-hidden="true">
                                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                                </div>

                                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                                    aria-hidden="true">&#8203;</span>

                                                <div x-show="openSuspend" x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                        <div class="sm:flex sm:items-start">
                                                            <div
                                                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg"
                                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                                </svg>
                                                            </div>
                                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                <h3 class="text-lg leading-6 font-medium text-gray-900">Suspend
                                                                    Account</h3>
                                                                <div class="mt-2">
                                                                    <p class="text-sm text-gray-500">
                                                                        Are you sure you want to suspend
                                                                        <strong>{{ $user->name }}</strong>'s account? They will no
                                                                        longer be able to log in or use any platform features.
                                                                        @if($user->employer)
                                                                            This will also hide all their internship listings and
                                                                            prevent students from applying.
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST"
                                                            class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                Confirm Suspension
                                                            </button>
                                                        </form>
                                                        <button @click="openSuspend = false" type="button"
                                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Activate Button -->
                                        <button @click="openActivate = true" type="button"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg class="h-3.5 w-3.5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                            </svg>
                                            Activate Account
                                        </button>

                                        <!-- Activate Confirmation Modal -->
                                        <div x-show="openActivate" class="fixed z-10 inset-0 overflow-y-auto"
                                            style="display: none;">
                                            <div
                                                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                <div x-show="openActivate" x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity"
                                                    aria-hidden="true">
                                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                                </div>

                                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                                    aria-hidden="true">&#8203;</span>

                                                <div x-show="openActivate" x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                        <div class="sm:flex sm:items-start">
                                                            <div
                                                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                                                <svg class="h-6 w-6 text-green-600"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </div>
                                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                <h3 class="text-lg leading-6 font-medium text-gray-900">Activate
                                                                    Account</h3>
                                                                <div class="mt-2">
                                                                    <p class="text-sm text-gray-500">
                                                                        Are you sure you want to activate
                                                                        <strong>{{ $user->name }}</strong>'s account? They will
                                                                        regain access to all platform features.
                                                                        @if($user->employer)
                                                                            This will also make all their internship listings visible
                                                                            again.
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST"
                                                            class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                Confirm Activation
                                                            </button>
                                                        </form>
                                                        <button @click="openActivate = false" type="button"
                                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex flex-col md:flex-row">
                        <!-- User Info -->
                        <div class="md:w-1/3 mb-6 md:mb-0">
                            <div class="flex items-center justify-center">
                                <div
                                    class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-2xl font-bold">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                            </div>

                            <div class="mt-4 text-center">
                                <h3 class="text-xl font-bold">{{ $user->name }}</h3>
                                <p class="text-gray-600">{{ $user->email }}</p>

                                <div class="mt-3 flex flex-wrap gap-2 justify-center">
                                    @if ($user->admin)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor"
                                                viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            {{ ucfirst($user->admin->role) }}
                                        </span>
                                    @elseif ($user->employer)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor"
                                                viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Employer
                                        </span>
                                    @elseif ($user->student)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor"
                                                viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Student
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-gray-400" fill="currentColor"
                                                viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Regular User
                                        </span>
                                    @endif

                                    @if (!$user->admin)
                                        @if($user->is_active)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                                    viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor"
                                                    viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Suspended
                                            </span>
                                        @endif
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <p class="text-sm text-gray-500">Member since:
                                        {{ $user->created_at->format('F j, Y') }}
                                    </p>
                                    <p class="text-sm text-gray-500">Last login:
                                        {{ $user->last_login_at ? $user->last_login_at->format('F j, Y H:i') : 'Never' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Account Information -->
                         @if (!$user->isAdmin())
                         <div
                            class="md:w-2/3 md:pl-8 border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-8">
                            <h3 class="text-lg font-semibold mb-4">Account Information</h3>

                            <div class="space-y-6">
                                @if($user->employer )
                                    <div>
                                        <h4 class="text-md font-medium mb-2">Employer Details</h4>
                                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Company Name</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ $user->employer->employer_name ?? 'N/A' }}
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Industry</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ $user->employer->industry ?? 'N/A' }}
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ $user->employer->phone ?? 'N/A' }}
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Website</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        @if($user->employer->website)
                                                            <a href="{{ $user->employer->website }}" target="_blank"
                                                                class="text-blue-600 hover:underline">{{ $user->employer->website }}</a>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-2">
                                                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ $user->employer->location ?? 'N/A' }}
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-2">
    <dt class="text-sm font-medium text-gray-500">Description</dt>
    <dd class="mt-1 text-sm text-gray-900 break-words">
        {{ $user->employer->description ?? 'No company description provided' }}
    </dd>
</div>
                                            </dl>
                                        </div>
                                    </div>
                                @elseif($user->student)
                                    <div>
                                        <h4 class="text-md font-medium mb-2">Student Details</h4>
                                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
                                                <!-- Education Info -->
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Education Level</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        @if($user->student->education_level)
                                                            {{ ucfirst(str_replace('_', ' ', $user->student->education_level)) }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </dd>
                                                </div>

                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Institution/University
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ $user->student->institution ?? 'N/A' }}
                                                    </dd>
                                                </div>

                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Field of Study</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ $user->student->field_of_study ?? 'N/A' }}
                                                    </dd>
                                                </div>

                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Graduation Date</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ $user->student->graduation_date ? Carbon\Carbon::parse($user->student->graduation_date)->format('F j, Y') : 'N/A' }}
                                                    </dd>
                                                </div>

                                                <!-- Contact Info -->
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">
                                                        {{ $user->student->phone ?? 'N/A' }}
                                                    </dd>
                                                </div>

                                                <!-- Online Presence -->
                                                <div class="sm:col-span-2 border-t border-gray-200 pt-3 mt-3">
                                                    <dt class="text-sm font-medium text-gray-500 mb-2">Online Profiles</dt>
                                                    <dd class="flex flex-wrap gap-3">
                                                        @if($user->student->linkedin_url)
                                                            <a href="{{ $user->student->linkedin_url }}" target="_blank"
                                                                class="inline-flex items-center px-3 py-1 rounded-md text-sm bg-blue-50 text-blue-700 hover:bg-blue-100">
                                                                <svg class="h-4 w-4 mr-1" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                                                </svg>
                                                                LinkedIn
                                                            </a>
                                                        @endif

                                                        @if($user->student->github_url)
                                                            <a href="{{ $user->student->github_url }}" target="_blank"
                                                                class="inline-flex items-center px-3 py-1 rounded-md text-sm bg-gray-800 text-white hover:bg-gray-700">
                                                                <svg class="h-4 w-4 mr-1" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                                                </svg>
                                                                GitHub
                                                            </a>
                                                        @endif

                                                        @if($user->student->portfolio_url)
                                                            <a href="{{ $user->student->portfolio_url }}" target="_blank"
                                                                class="inline-flex items-center px-3 py-1 rounded-md text-sm bg-purple-50 text-purple-700 hover:bg-purple-100">
                                                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                                </svg>
                                                                Portfolio
                                                            </a>
                                                        @endif
                                                    </dd>
                                                </div>

                                                <!-- Documents -->
                                                <div class="sm:col-span-2 border-t border-gray-200 pt-3 mt-1">
                                                    <dt class="text-sm font-medium text-gray-500 mb-2">Documents</dt>
                                                    <dd>
                                                        @if($user->student->resume_path)
                                                            <a href="{{ Storage::url($user->student->resume_path) }}"
                                                                target="_blank"
                                                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                                </svg>
                                                                View Resume
                                                            </a>
                                                        @else
                                                            <span class="text-sm text-gray-500">No resume uploaded</span>
                                                        @endif

                                                        @if($user->student->profile_photo_path)
                                                            <a href="{{ Storage::url($user->student->profile_photo_path) }}"
                                                                target="_blank"
                                                                class="inline-flex items-center px-3 py-2 ml-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                                View Profile Photo
                                                            </a>
                                                        @endif
                                                    </dd>
                                                </div>

                                                <!-- Skills -->
                                                <div class="sm:col-span-2 border-t border-gray-200 pt-3 mt-1">
                                                    <dt class="text-sm font-medium text-gray-500 mb-2">Skills</dt>
                                                    <dd>
                                                        @if($user->student->skills)
                                                            <div class="flex flex-wrap gap-2">
                                                                @foreach(explode(',', $user->student->skills) as $skill)
                                                                    <span
                                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-indigo-100 text-indigo-800">
                                                                        {{ trim($skill) }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <span class="text-sm text-gray-500">No skills listed</span>
                                                        @endif
                                                    </dd>
                                                </div>

                                                <!-- Bio -->
                                                <div class="sm:col-span-2 border-t border-gray-200 pt-3 mt-1">
                                                    <dt class="text-sm font-medium text-gray-500 mb-2">Biography</dt>
                                                    <p class="text-sm text-gray-900 break-words">
                                                        {{ $user->student->bio ?? 'No biography provided' }}
                                                    </p>
                                                </div>
                                            </dl>

                                        </div>
                                    </div>
                                @endif

                                <!-- Activity Summary -->
                                <div>
                                    <h4 class="text-md font-medium mb-2">Activity Summary</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @if($user->employer)
                                            <div class="bg-blue-50 px-4 py-3 rounded-lg text-center">
                                                <span
                                                    class="text-2xl font-bold text-blue-700">{{ $user->employer->internships()->count() ?? 0 }}</span>
                                                <p class="text-sm text-blue-600">Internships Posted</p>
                                            </div>
                                            <div class="bg-green-50 px-4 py-3 rounded-lg text-center">
                                                <span
                                                    class="text-2xl font-bold text-green-700">{{ $userData['totalApplicants'] }}</span>
                                                <p class="text-sm text-green-600">Applications Received</p>
                                            </div>
                                        @elseif($user->student)
                                        
                                            <div class="bg-blue-50 px-4 py-3 rounded-lg text-center">
                                                <span
                                                    class="text-2xl font-bold text-blue-700">{{ $user->applications()->count() ?? 0 }}</span>
                                                <p class="text-sm text-blue-600">Applications Submitted</p>
                                            </div>
                                            <div class="bg-green-50 px-4 py-3 rounded-lg text-center">
                                                <span
                                                    class="text-2xl font-bold text-green-700">{{ $user->student->accepted_applications_count ?? 0 }}</span>
                                                <p class="text-sm text-green-600">Accepted Applications</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
            <!-- Applications Submitted Section -->
            @if($user->student)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="border-b border-gray-200">
                        <div class="px-6 py-4">
                            <h2 class="text-xl font-bold text-gray-900">Applications Submitted</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        @php
                            $applications = \App\Models\Application::where('user_id', $user->id)
                                ->with(['internship.employer'])
                                ->latest()
                                ->get();
                        @endphp

                        @if($applications->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Internship</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Company</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Applied Date</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($applications as $application)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    {{ $application->internship->title }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $application->internship->employer->employer_name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $application->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $statusColors = [
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'reviewing' => 'bg-blue-100 text-blue-800',
                                                            'interviewed' => 'bg-purple-100 text-purple-800',
                                                            'accepted' => 'bg-green-100 text-green-800',
                                                            'rejected' => 'bg-red-100 text-red-800',
                                                        ];
                                                        $statusColor = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800';
                                                    @endphp
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                                        {{ ucfirst($application->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('admin.applications.show', $application) }}"
                                                        class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($applications->count() > 10)
                                <div class="mt-4 flex justify-center">
                                    <a href="{{ route('admin.applications') }}?user_id={{ $user->id }}"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        View All Applications
                                        <svg class="ml-1.5 -mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No applications</h3>
                                <p class="mt-1 text-sm text-gray-500">This student hasn't submitted any applications yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
<!-- Employer Internships Section -->
@if($user->employer)
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
        <div class="border-b border-gray-200">
            <div class="px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Internships Posted</h2>
                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    Total: {{ $user->employer->internships()->count() }}
                </span>
            </div>
        </div>
        <div class="p-6">
            @php
                $internships = $user->employer->internships()->latest()->get();
            @endphp
            
            @if($internships->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applications</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($internships as $internship)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        {{ $internship->title }}
                                    </td>
                
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $internship->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ Carbon\Carbon::parse($internship->application_deadline)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($internship->is_active)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                        {{ $internship->applications->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.internships.show', $internship) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($internships->count() > 10)
                    <div class="mt-4 flex justify-center">
                        <a href="{{ route('admin.internships') }}?employer_id={{ $user->employer->id }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View All Internships
                            <svg class="ml-1.5 -mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No internships</h3>
                    <p class="mt-1 text-sm text-gray-500">This employer hasn't posted any internships yet.</p>
                </div>
            @endif
        </div>
    </div>
@endif
<!-- Applications Received Section -->
@if($user->employer)
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
        <div class="border-b border-gray-200">
            <div class="px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Applications Received</h2>
                <div class="flex space-x-2">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        Total: {{ $userData['totalApplicants'] ?? 0 }}
                    </span>
                </div>
            </div>
        </div>
        <div class="p-6">
            @php
                $employerInternshipIds = $user->employer->internships()->pluck('id');
                $applications = \App\Models\Application::whereIn('internship_id', $employerInternshipIds)
                    ->with(['user', 'internship'])
                    ->latest()
                    ->take(10)
                    ->get();
            @endphp
            
            @if($applications->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Internship</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($applications as $application)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs font-bold">
                                                <a href="{{ route('admin.users.show', $application->user) }}" >{{ substr($application->user->name, 0, 2) }}
                                                
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-blue-600 hover:text-blue-900 hover:underline">
                                                    {{ $application->user->name }}
                                                </div></a>
                                                <div class="text-sm text-gray-500">
                                                    {{ $application->user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.internships.show', $application->internship) }}">
                                        {{ $application->internship->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $application->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'reviewing' => 'bg-blue-100 text-blue-800',
                                                'interviewed' => 'bg-purple-100 text-purple-800',
                                                'accepted' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusColor = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.applications.show', $application) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($userData['totalApplicants'] > 10)
                    <div class="mt-4 flex justify-center">
                        <a href="{{ route('admin.applications') }}?employer_id={{ $user->employer->id }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View All Applications
                            <svg class="ml-1.5 -mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No applications</h3>
                    <p class="mt-1 text-sm text-gray-500">This employer hasn't received any applications yet.</p>
                </div>
            @endif
        </div>
    </div>
@endif
@endif

        </div>
    </div>
</x-app-layout>