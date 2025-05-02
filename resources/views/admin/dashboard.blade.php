<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">System Statistics</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
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

                        <div class="bg-red-100 p-4 rounded-lg shadow">
                            <div class="text-3xl font-bold">{{ $stats['admin_count'] }}</div>
                            <div class="text-sm text-gray-600">Admins</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Recent Internships -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col min-h-[200px]">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Recent Internships</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white ">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left">Title</th>
                                        <th class="py-2 px-4 border-b text-left">Employer</th>
                                        <th class="py-2 px-4 border-b text-center">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentInternships as $internship)
                                        <tr>
                                            <td class="py-2 px-4 border-b">
                                                <a href="{{ route('admin.internships.show', $internship) }}"
                                                    class="text-blue-600 hover:underline">
                                                    {{ Str::limit($internship->title, 30) }}
                                                </a>
                                            </td>
                                            <td class="py-2 px-4 border-b text-sm">
                                                {{ $internship->employer->employer_name }}</td>
                                            <td class="py-2 px-4 border-b text-center text-sm whitespace-nowrap">
                                                {{ $internship->created_at->format('M d, Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-2 px-4 border-b text-center">No recent internships
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="p-6 mt-auto">
                        <a href="{{ route('admin.internships') }}" class="text-blue-600 hover:underline">View all
                            internships →</a>
                    </div>
                </div>

                <!-- Recent Applications -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col min-h-[200px]">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Recent Applications</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left">User</th>
                                        <th class="py-2 px-4 border-b text-center">Internship</th>
                                        <th class="py-2 px-4 border-b text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentApplications as $application)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $application->user->name }}</td>
                                            <td class="py-2 px-4 border-b text-center">
                                                <a href="{{ route('admin.internships.show', $application->internship) }}"
                                                    class="text-blue-600 hover:underline">
                                                    {{ Str::limit($application->internship->title, 30) }}
                                                </a>
                                            </td>
                                            <td class="py-2 px-4 border-b text-center">
                                                <span
                                                    class="px-2 py-1 rounded text-xs 
                                                {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $application->status === 'reviewing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $application->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $application->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-2 px-4 border-b text-center">No recent applications
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="p-6 mt-auto">
                        <a href="{{ route('admin.applications') }}" class="text-blue-600 hover:underline">View all
                            applications →</a>
                    </div>
                </div>
            </div>

            <!-- New Users Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">New Users</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Name</th>
                                    <th class="py-2 px-4 border-b text-center">Email</th>
                                    <th class="py-2 px-4 border-b text-center">Joined</th>
                                    <th class="py-2 px-4 border-b text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $user)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                                        <td class="py-2 px-4 border-b text-center">{{ $user->email }}</td>
                                        <td class="py-2 px-4 border-b text-center">{{ $user->created_at->diffForHumans() }}</td>
                                        <td class="py-2 px-4 border-b text-center">
                                            <a href="{{ route('admin.users.show', $user) }}"
                                                class="text-blue-600 hover:underline">View Profile</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-2 px-4 border-b text-center">No recent users</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.users') }}" class="text-blue-600 hover:underline">View all users →</a>
                    </div>
                </div>
            </div>

            <!-- Monthly Stats Charts -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Monthly Activity</h3>

                    <div class="h-80">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('monthlyChart').getContext('2d');

            // Prepare data from PHP variables
            const monthlyStats = @json($monthlyStats);

            // Prepare labels (months)
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            // Format data for Chart.js
            const userData = months.map((_, index) => {
                const monthNum = (index + 1).toString().padStart(2, '0');
                return monthlyStats.users[monthNum] || 0;
            });

            const internshipData = months.map((_, index) => {
                const monthNum = (index + 1).toString().padStart(2, '0');
                return monthlyStats.internships[monthNum] || 0;
            });

            const applicationData = months.map((_, index) => {
                const monthNum = (index + 1).toString().padStart(2, '0');
                return monthlyStats.applications[monthNum] || 0;
            });

            // Create chart
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Users',
                            data: userData,
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 2
                        },
                        {
                            label: 'Internships',
                            data: internshipData,
                            backgroundColor: 'rgba(245, 158, 11, 0.2)',
                            borderColor: 'rgba(245, 158, 11, 1)',
                            borderWidth: 2
                        },
                        {
                            label: 'Applications',
                            data: applicationData,
                            backgroundColor: 'rgba(139, 92, 246, 0.2)',
                            borderColor: 'rgba(139, 92, 246, 1)',
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Monthly Activity ({{ date('Y') }})'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

</x-app-layout>