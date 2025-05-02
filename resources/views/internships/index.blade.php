<x-layout>
    <div class="space-y-6">

        <section class="text-center">

            <div class="bg-gradient-to-b from-gray-50 to-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
                    <div class="text-center">
                        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight">
                            Find Your Perfect <span class="text-indigo-600">Internship</span> Today
                        </h1>
                        <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-600">
                            Launch your career with thousands of internship opportunities across all industries
                        </p>

                        <!-- Search Box -->
                        <div class="mt-8 max-w-3xl mx-auto">
                            <form action="{{ url('/search') }}" method="GET" class="sm:flex">
                                <div class="flex-1 min-w-0">
                                    <input type="text" name="search"
                                        placeholder="Search for internships, companies, or keywords"
                                        class="block w-full px-4 py-3 rounded-l-md border border-gray-300 shadow-sm text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div class="mt-3 sm:mt-0 sm:ml-3">
                                    <button type="submit"
                                        class="block w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-r-md text-white font-medium focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Search Internships
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Popular Tags -->
                        <div class="mt-8">
                            <h2 class="text-sm uppercase tracking-widest text-gray-500 mb-4">Popular Categories</h2>
                            <div class="flex flex-wrap justify-center gap-2">

                                @foreach ($tags as $tag)
                                    <x-tag :$tag />
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section> 
            <x-section-heading>Featured Internships</x-section-heading>
    <div class="grid lg:grid-cols-3 gap-8 mt-6">
        @forelse ($featuredInternships as $internship)
            <x-internship-card :$internship :colorScheme="$loop->index % 2 === 0 ? 'indigo' : 'blue'" />
        @empty
            <div class="col-span-3 text-center py-8 text-gray-500">
                No featured internships available at the moment.
            </div>
        @endforelse
    </div>
    
    <!-- Featured Internships Pagination Links -->
    @if($featuredInternships->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $featuredInternships->links() }}
        </div>
    @endif
</section>


        <section>
            <x-section-heading>Recent Internships</x-section-heading>
            <div class="mt-6 space-y-6">
                @foreach($internships as $index => $internship)
                    @php
                        $colors = ['indigo', 'blue', 'purple', 'green'];
                        $colorScheme = $colors[$index % count($colors)];
                    @endphp
                    <x-internship-card-wide-tr :$internship :colorScheme="$colorScheme" />
                @endforeach
            </div>
            <!-- Pagination Links -->
            <div class="mt-8">
                {{ $internships->links() }}
            </div>
        </section>

    </div>


</x-layout>