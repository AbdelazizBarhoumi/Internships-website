<x-layout>
    <x-page-heading>{{ auth()->user()?->isEmployer() ? 'Manage Internship' : 'Internship Details' }}</x-page-heading>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <x-alert-success :message="session('success')" />

        @auth
            @if(auth()->user()->isEmployer())
                @include('internships.partials.employer-view', ['internship' => $internship])
            @else
                @include('internships.partials.student-view', ['internship' => $internship])
            @endif
        @else
            @include('internships.partials.student-view', ['internship' => $internship])
        @endauth
    </div>
</x-layout>