<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">System Statistics</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-blue-100 p-4 rounded-lg shadow">
                            <div class="text-3xl font-bold">{{ $stats['users'] }}</div>
                            <div class="text-sm text-gray-600">Total Users</div>
                        </div>
                        
                        <div class="bg-green-100 p-4 rounded-lg shadow">
                            <div class="text-3xl font-bold">{{ $stats['employers'] }}</div>
                            <div class="text-sm text-gray-600">Employers</div>
                        </div>
                        
                        <div class="bg-yellow-100 p-4 rounded-lg shadow">
                            <div class="text-3xl font-bold">{{ $stats['internships'] }}</div>
                            <div class="text-sm text-gray-600">Internships</div>
                        </div>
                        
                        <div class="bg-purple-100 p-4 rounded-lg shadow">
                            <div class="text-3xl font-bold">{{ $stats['applications'] }}</div>
                            <div class="text-sm text-gray-600">Applications</div>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                        
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Manage Users
                            </a>
                            <!-- Add more quick action buttons as needed -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>