@props(['internship'])
<x-layout>
    @if ($search == '')
        <x-page-heading>Search for Internships</x-page-heading>
    @else
        <x-page-heading>Results for "{{ $search }}"</x-page-heading>
    @endif
    <div class="space-y-6">     
        <x-forms.form action="/search" class="mt-6 justify-center items-center">
            <x-forms.input :label="false" name="search" :value="$search" placeholder="I'm looking for..."
                class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 text-lg focus:outline-none focus:border-blue-800 focus:ring-1 focus:ring-blue-800 transition-colors duration-300 max-w-xl" />
            <x-forms.button class="mt-4 bg-blue-600 text-white rounded-xl px-4 py-2">Search</x-forms.button>
        </x-forms.form>
        @foreach ($internships as $internship)
            <x-internship-card-wide-tr :internship="$internship" :searchedTag="$searchedTag ?? null" />
        @endforeach

        <div class="pagination-dark">
            {{ $internships->links() }} 
        </div>
    </div>

</x-layout>