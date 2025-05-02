<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Discover your perfect internship - Browse thousands of opportunities across all industries">
    <title>{{ $title ?? 'InternNexus - Find Your Perfect Internship' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-white text-gray-600 font-hanken min-h-screen flex flex-col">
    <!-- Header and Navigation -->
    <header class="sticky top-0 bg-white/95 backdrop-blur-sm z-30 border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="relative flex items-center h-16">
                <!-- Logo (absolutely positioned to the left) -->
                <div class="absolute left-0">
                    <a href="/" class="flex items-center">
                        <img src="{{ Vite::asset('resources/images/logo.svg') }}" alt="InternNexus" class="h-8 w-auto">
                    </a>
                </div>
                <!-- Desktop Navigation (centered) -->
                <div class="w-full flex justify-center">
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('home') }}"
                            class="text-gray-800 font-medium text-sm hover:text-indigo-600 transition-colors">Internships</a>
                        <a href="#"
                            class="text-gray-500 font-medium text-sm hover:text-indigo-600 transition-colors">Careers</a>
                        <a href="#"
                            class="text-gray-500 font-medium text-sm hover:text-indigo-600 transition-colors">Salaries</a>
                        <a href="#"
                            class="text-gray-500 font-medium text-sm hover:text-indigo-600 transition-colors">Companies</a>
                    </div>
                </div>
                <!-- Auth Navigation -->
                <div class="absolute right-0 flex items-center">
                @if (Route::has('login'))
                        <div class="flex items-center space-x-4">
                            @auth
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" type="button"
                                        class="flex items-center text-sm text-gray-700 hover:text-indigo-600 focus:outline-none">
                                        <span>{{ Auth::user()->name }}</span>
                                        <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <div x-show="open" @click.away="open = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 mt-2 w-48 py-1 bg-white border border-gray-200 rounded-md shadow-lg z-50"
                                        style="display: none;">
                                        <a href="{{ url('/dashboard') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                        <a href="{{ route('profile.edit') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Sign out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 px-3 py-2 text-sm">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-150">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif

                    <!-- Mobile menu button -->
                    <div class="md:hidden ml-4">
                        <button type="button" x-data="{ open: false }" @click="open = !open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-indigo-600 hover:bg-gray-100 focus:outline-none">
                            <span class="sr-only">Open main menu</span>
                            <!-- Heroicon name: menu -->
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Mobile menu, show/hide based on menu state -->
        <div x-data="{ open: false }" x-show="open" @click.away="open = false"
            class="md:hidden bg-white border-t border-gray-200" style="display: none;">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-800 hover:bg-gray-100">Internships</a>
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-100 hover:text-indigo-600">Careers</a>
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-100 hover:text-indigo-600">Salaries</a>
                <a href="#"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:bg-gray-100 hover:text-indigo-600">Companies</a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        <!-- Hero Section for Landing Page -->
        @php
            $showHero = isset($showHero) ? $showHero : true; // Default to true if not set
         @endphp
        @if(isset($showHero) && $showHero)

        @endif

        <!-- Content Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </div>
    </main>
@if ($showHero)
    <!-- Newsletter Section -->
    <section class="bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900">Get the Latest Internship Opportunities</h2>
                <p class="mt-3 max-w-2xl mx-auto text-gray-600">
                    Join our newsletter and be the first to know about new internships matching your preferences.
                </p>



                <form class="sm:flex pt-5">
                                <div class="flex-1 min-w-0">
                                <label for="email" class="sr-only">Email address</label>
                                    <input id="email" type="email" name="email"
                                        placeholder="Enter your email"
                                        class="block w-full px-4 py-3 rounded-l-md border border-gray-300 shadow-sm text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div class="mt-3 sm:mt-0 sm:ml-3">
                                    <button type="submit"
                                        class="block w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-r-md text-white font-medium focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Subscribe
                                    </button>
                                </div>
                            </form>
                            @endif
               
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-100 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="col-span-2">
                    <a href="/" class="flex items-center">
                        <img src="{{ Vite::asset('resources/images/logo.svg') }}" alt="InternNexus" class="h-8 w-auto">
                    </a>
                    <p class="mt-4 text-gray-600 text-sm">
                        InternNexus connects talented students with the best internship opportunities worldwide.
                        Start your career journey with us today.
                    </p>
                    <div class="mt-6 flex space-x-6">
                        <a href="#" class="text-gray-500 hover:text-indigo-600">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-indigo-600">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">For Students</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Browse Internships</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Career Resources</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Resume Builder</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Interview Prep</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">For Employers</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Post Internships</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Talent Sourcing</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Employer Branding</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Our Pricing</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-200 text-center">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} InternNexus. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>