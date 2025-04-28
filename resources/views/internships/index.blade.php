<x-layout>
    <div class="space-y-10">

        <section class="text-center">
            <h1 class="font-bold text-4xl pt-6">Lets find your next Internship</h1>
            <x-forms.form action="/search" class="mt-6 justify-center items-center">
                <x-forms.input :label="false" name="search" placeholder="I'm looking for..."
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 text-lg focus:outline-none focus:border-blue-800 focus:ring-1 focus:ring-blue-800 transition-colors duration-300 max-w-xl" />
                <x-forms.button class="mt-4 bg-blue-600 text-white rounded-xl px-4 py-2">Search</x-forms.button>
            </x-forms.form>

        </section>

        <section class="pt-10">
            <x-section-heading>Featured Internships</x-section-heading>
            <div class="grid lg:grid-cols-3 gap-8 mt-6">
                    <!-- Modified: Added 'h-64' to set a fixed height (16rem) to ensure the background covers the entire card -->
                        @foreach ($featuredInternships as $internship)
                            <x-internship-card :$internship />
                        @endforeach
                </div>

        </section>


        <section>
            <x-section-heading>Tags</x-section-heading>
            <div class="mt-6 flex flex-wrap gap-2">

                @foreach ($tags as $tag)
                    <x-tag :$tag />
                @endforeach
            </div>
        </section>

        <section>
            <x-section-heading>Recent Internships</x-section-heading>
            <div class="mt-6 space-y-6">
                @foreach ($internships as $internship)
                    <x-internship-card-wide-tr :$internship />
                @endforeach
            </div>
        </section>

    </div>


</x-layout>