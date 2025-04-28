<div class="flex justify-between mb-4">
    <h1 class="text-2xl font-bold text-gray-900">{{ $internship->title }}</h1>
    @can('update', $internship)
        <div class="flex gap-2">
            <a href="{{ route('myinternship.edit', $internship) }}" class="btn btn-blue">
                <x-icon.edit class="h-4 w-4 mr-1" /> Edit
            </a>
            <form method="POST" action="{{ route('myinternship.destroy', $internship) }}" onsubmit="return confirm('Are you sure?')">
                @csrf @method('DELETE')
                <button class="btn btn-red">
                    <x-icon.trash class="h-4 w-4 mr-1" /> Delete
                </button>
            </form>
        </div>
    @endcan
</div>

<x-internship.featured-badge :internship="$internship" />

<div class="bg-gray-50 p-4 rounded-lg mb-6">
    <h2 class="text-lg font-semibold mb-3">Application Statistics</h2>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-stats-card label="Total Applications" :value="$internship->applications->count()" />
        <x-stats-card label="Pending Review" :value="$internship->applications()->where('status', 'pending')->count()" class="text-indigo-600" />
        <x-stats-card label="Accepted" :value="$internship->applications()->where('status', 'accepted')->count()" class="text-green-600" />
    </div>
    <a href="{{ route('applications.index', ['internship_id' => $internship->id]) }}" class="text-indigo-600 hover:text-indigo-700 mt-4 block">
        View All Applications →
    </a>
</div>

<x-internship.info-grid :internship="$internship" />
<x-internship.description :internship="$internship" />
<x-internship.tags :tags="$internship->tags" />

<a href="{{ route('dashboard') }}" class="btn btn-gray mt-6">Back to Dashboard</a>