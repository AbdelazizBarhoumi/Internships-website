<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('System Settings') }}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        
                        <!-- General Settings -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b">General Settings</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Site Name -->
                                <div>
                                    <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Site Name
                                    </label>
                                    <input type="text" name="site_name" id="site_name" 
                                        value="{{ $settings['site_name'] }}"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                                    @error('site_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Registration Open -->
                                <div class="flex items-center">
                                    <input type="checkbox" name="registration_open" id="registration_open" 
                                        value="1" {{ $settings['registration_open'] ? 'checked' : '' }}
                                        class="h-5 w-5 text-blue-600">
                                    <label for="registration_open" class="ml-2 block text-sm font-medium text-gray-700">
                                        Allow New User Registration
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Employer Settings -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b">Employer Settings</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Employer Approval -->
                                <div class="flex items-center">
                                    <input type="checkbox" name="employer_approval_required" id="employer_approval_required" 
                                        value="1" {{ $settings['employer_approval_required'] ? 'checked' : '' }}
                                        class="h-5 w-5 text-blue-600">
                                    <label for="employer_approval_required" class="ml-2 block text-sm font-medium text-gray-700">
                                        Require Admin Approval for Employer Accounts
                                    </label>
                                </div>
                                
                                <!-- Max Internships Per Employer -->
                                <div>
                                    <label for="max_internships_per_employer" class="block text-sm font-medium text-gray-700 mb-1">
                                        Maximum Internships Per Employer (0 = unlimited)
                                    </label>
                                    <input type="number" name="max_internships_per_employer" id="max_internships_per_employer" 
                                        value="{{ $settings['max_internships_per_employer'] }}"
                                        min="0" max="100"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Settings -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b">User Settings</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Max Applications Per User -->
                                <div>
                                    <label for="max_applications_per_user" class="block text-sm font-medium text-gray-700 mb-1">
                                        Maximum Applications Per User (0 = unlimited)
                                    </label>
                                    <input type="number" name="max_applications_per_user" id="max_applications_per_user" 
                                        value="{{ $settings['max_applications_per_user'] }}"
                                        min="0" max="100"
                                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-200">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Additional Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">System Maintenance</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <h4 class="font-medium mb-2">Cache Management</h4>
                            <div class="space-y-2">
                                <form action="#" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm">
                                        Clear Application Cache
                                    </button>
                                </form>
                                
                                <form action="#" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm">
                                        Clear View Cache
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium mb-2">System Information</h4>
                            <div class="text-sm">
                                <div class="mb-1">
                                    <span class="font-medium">PHP Version:</span> {{ phpversion() }}
                                </div>
                                <div class="mb-1">
                                    <span class="font-medium">Laravel Version:</span> {{ app()->version() }}
                                </div>
                                <div class="mb-1">
                                    <span class="font-medium">Environment:</span> {{ config('app.env') }}
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium mb-2">Database</h4>
                            <div class="space-y-2">
                                <a href="#" class="block w-full px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm text-center">
                                    Export Database Backup
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>