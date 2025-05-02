<x-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Internship Card Style Test</h1>
        
        <h2 class="text-lg font-medium text-gray-800 mb-4">Style 1: Detailed Cards (1 per row)</h2>
        
        <!-- Detailed Internship Cards (1-per-row) -->
        <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-12">
            <!-- Detailed Card 1 -->
            <div class="relative bg-white border border-gray-100 hover:border-indigo-100 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-5">
                        <!-- Company Logo -->
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-indigo-50 rounded-lg border border-gray-100 overflow-hidden shadow-sm flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 leading-tight hover:text-indigo-700 transition-colors">
                                        <a href="#" class="hover:underline decoration-2 decoration-indigo-500 underline-offset-2"> 
                                            Frontend Developer Intern
                                        </a>
                                    </h3>
                                    <div class="flex items-center mt-1.5 text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <span class="text-sm">TechVision Solutions</span>
                                    </div>
                                </div>

                                <div class="mt-2 sm:mt-0 flex space-x-2">
                                    <!-- Moved Paid badge here, next to days left badge -->
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        Paid
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        7 days left
                                    </span>
                                </div>
                            </div>

                            <!-- Brief Description -->
                            <p class="mt-3 text-sm text-gray-600 line-clamp-2">
                                Join our innovative team and gain hands-on experience building responsive web applications using React, TypeScript, and modern CSS frameworks.
                            </p>
                            
                            <!-- Location and Details -->
                            <div class="flex flex-wrap items-center mt-4 gap-x-4 gap-y-2 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    San Francisco
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Full-time
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    $25-30/hour
                                </div>
                            </div>

                            <!-- Tags -->
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    React
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    TypeScript
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Frontend
                                </span>
                            </div>
                            
                            <!-- Footer with posted time and apply button -->
                            <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Posted 3 days ago
                                </div>
                                <div class="mt-3 sm:mt-0 flex">
                                    <button class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                        </svg>
                                        Save
                                    </button>
                                    <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                        Apply Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Card 2 -->
            <div class="relative bg-white border border-gray-100 hover:border-indigo-100 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-5">
                        <!-- Company Logo -->
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-blue-50 rounded-lg border border-gray-100 overflow-hidden shadow-sm flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 leading-tight hover:text-blue-700 transition-colors">
                                        <a href="#" class="hover:underline decoration-2 decoration-blue-500 underline-offset-2"> 
                                            Data Science Intern
                                        </a>
                                    </h3>
                                    <div class="flex items-center mt-1.5 text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <span class="text-sm">DataBlend Analytics</span>
                                    </div>
                                </div>

                                <div class="mt-2 sm:mt-0 flex space-x-2">
                                    <!-- Moved Remote badge here, next to days left badge -->
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        Remote
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        14 days left
                                    </span>
                                </div>
                            </div>

                            <!-- Brief Description -->
                            <p class="mt-3 text-sm text-gray-600 line-clamp-2">
                                Perfect opportunity for students passionate about data science. You'll work with our analytics team to collect, process, and analyze large datasets.
                            </p>
                            
                            <!-- Location and Details -->
                            <div class="flex flex-wrap items-center mt-4 gap-x-4 gap-y-2 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Remote
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Part-time
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    $22/hour
                                </div>
                            </div>

                            <!-- Tags -->
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Python
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Data Analysis
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Machine Learning
                                </span>
                            </div>
                            
                            <!-- Footer with posted time and apply button -->
                            <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Posted 1 week ago
                                </div>
                                <div class="mt-3 sm:mt-0 flex">
                                    <button class="inline-flex items-center text-blue-600 hover:text-blue-800 mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                        </svg>
                                        Save
                                    </button>
                                    <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                        Apply Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <h2 class="text-lg font-medium text-gray-800 mb-4">Style 2: Compact Cards (3 per row)</h2>
        
        <!-- Compact Internship Cards (3-per-row) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- No changes needed to the compact cards since they don't have the overlap issue -->
            <!-- Compact Card 1 -->
            <div class="bg-white border border-gray-100 hover:border-indigo-100 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                <div class="border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-white px-4 py-3">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-md bg-indigo-100 flex items-center justify-center mr-3 border border-indigo-200">
                                <span class="text-indigo-700 font-semibold text-sm">MS</span>
                            </div>
                            <h4 class="font-medium text-gray-900 truncate">MindShare Technologies</h4>
                        </div>
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            Paid
                        </span>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 leading-snug mb-2 hover:text-indigo-700 transition-colors">
                        <a href="#" class="hover:underline decoration-2 decoration-indigo-500 underline-offset-2">
                            UI/UX Design Intern
                        </a>
                    </h3>
                    
                    <div class="flex flex-wrap gap-1 mb-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            UI/UX
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Figma
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Design
                        </span>
                    </div>
                    
                    <div class="flex flex-wrap text-xs text-gray-600 mb-3 gap-x-3 gap-y-1">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            New York
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Full-time
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-xs text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-amber-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            5 days left
                        </div>
                        <a href="#" class="inline-flex items-center text-xs font-medium text-indigo-600 hover:text-indigo-800">
                            View Details
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-0.5 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Compact Card 2 -->
            <div class="bg-white border border-gray-100 hover:border-purple-100 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                <div class="border-b border-gray-100 bg-gradient-to-r from-purple-50 to-white px-4 py-3">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-md bg-purple-100 flex items-center justify-center mr-3 border border-purple-200">
                                <span class="text-purple-700 font-semibold text-sm">GM</span>
                            </div>
                            <h4 class="font-medium text-gray-900 truncate">GrowthGenius Marketing</h4>
                        </div>
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                            New
                        </span>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 leading-snug mb-2 hover:text-purple-700 transition-colors">
                        <a href="#" class="hover:underline decoration-2 decoration-purple-500 underline-offset-2">
                            Marketing & Social Media Intern
                        </a>
                    </h3>
                    
                    <div class="flex flex-wrap gap-1 mb-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            Social Media
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Content
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Analytics
                        </span>
                    </div>
                    
                    <div class="flex flex-wrap text-xs text-gray-600 mb-3 gap-x-3 gap-y-1">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            Chicago
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Part-time
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-xs text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Posted yesterday
                        </div>
                        <a href="#" class="inline-flex items-center text-xs font-medium text-purple-600 hover:text-purple-800">
                            View Details
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-0.5 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Compact Card 3 -->
            <div class="bg-white border border-gray-100 hover:border-green-100 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                <div class="border-b border-gray-100 bg-gradient-to-r from-green-50 to-white px-4 py-3">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-md bg-green-100 flex items-center justify-center mr-3 border border-green-200">
                                <span class="text-green-700 font-semibold text-sm">EF</span>
                            </div>
                            <h4 class="font-medium text-gray-900 truncate">EcoFuture Innovations</h4>
                        </div>
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            Paid
                        </span>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 leading-snug mb-2 hover:text-green-700 transition-colors">
                        <a href="#" class="hover:underline decoration-2 decoration-green-500 underline-offset-2">
                            Environmental Research Assistant
                        </a>
                    </h3>
                    
                    <div class="flex flex-wrap gap-1 mb-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Research
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Sustainability
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Science
                        </span>
                    </div>
                    
                    <div class="flex flex-wrap text-xs text-gray-600 mb-3 gap-x-3 gap-y-1">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            Portland, OR
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Summer
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-xs text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Posted 2 days ago
                        </div>
                        <a href="#" class="inline-flex items-center text-xs font-medium text-green-600 hover:text-green-800">
                            View Details
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-0.5 h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>