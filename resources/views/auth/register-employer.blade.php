<x-guest-layout>
    <div class="mb-6 flex items-center">
        <a href="{{ route('register') }}" class="flex items-center text-sm text-gray-600 hover:text-indigo-600 transition-colors mr-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back
        </a>
        <h2 class="text-2xl font-bold text-gray-900">Employer Registration</h2>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 max-w-3xl mx-auto">
        <div class="p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-6 pb-6 border-b">
                <div class="p-4 bg-purple-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Join as an Employer</h3>
                    <p class="mt-1 text-sm text-gray-600">Create your employer account to start posting internship opportunities</p>
                </div>
            </div>

            <form method="POST" action="{{ route('register.employer.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="border-b pb-6 mb-6">
                    <h4 class="font-medium text-gray-900 mb-4">Account Information</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Contact Person Name -->
                        <div>
                            <x-input-label for="name" :value="__('Contact Person Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Your name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">The primary contact person for this account</p>
                        </div>

                        <!-- Email Address (User Account) -->
                        <div>
                            <x-input-label for="email" :value="__('Business Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="company@example.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">We'll send a verification email to this address</p>
                        </div>
                        
                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <div class="relative">
                                <x-text-input id="password" class="block mt-1 w-full pr-10"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password"
                                    placeholder="Minimum 8 characters" />
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" 
                                required autocomplete="new-password" 
                                placeholder="Re-enter your password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="border-b pb-6 mb-6">
                    <h4 class="font-medium text-gray-900 mb-4">Company Information</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Company Name -->
                        <div>
                            <x-input-label for="employer_name" :value="__('Company Name')" />
                            <x-text-input id="employer_name" class="block mt-1 w-full" type="text" name="employer_name" :value="old('employer_name')" required placeholder="Your organization's name" />
                            <x-input-error :messages="$errors->get('employer_name')" class="mt-2" />
                        </div>

                        <!-- Company Email -->
                        <div>
                            <x-input-label for="employer_email" :value="__('Public Contact Email')" />
                            <x-text-input id="employer_email" class="block mt-1 w-full" type="email" name="employer_email" :value="old('employer_email')" required placeholder="contact@example.com" />
                            <x-input-error :messages="$errors->get('employer_email')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">This will be visible to applicants</p>
                        </div>

                        <!-- Industry -->
                        <div>
                            <x-input-label for="industry" :value="__('Industry')" />
                            <select id="industry" name="industry" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Industry</option>
                                <option value="Technology" {{ old('industry') == 'Technology' ? 'selected' : '' }}>Technology</option>
                                <option value="Finance" {{ old('industry') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Healthcare" {{ old('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                <option value="Education" {{ old('industry') == 'Education' ? 'selected' : '' }}>Education</option>
                                <option value="Manufacturing" {{ old('industry') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                <option value="Retail" {{ old('industry') == 'Retail' ? 'selected' : '' }}>Retail</option>
                                <option value="Marketing" {{ old('industry') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Hospitality" {{ old('industry') == 'Hospitality' ? 'selected' : '' }}>Hospitality</option>
                                <option value="Consulting" {{ old('industry') == 'Consulting' ? 'selected' : '' }}>Consulting</option>
                                <option value="Media" {{ old('industry') == 'Media' ? 'selected' : '' }}>Media</option>
                                <option value="Other" {{ old('industry') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div>
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" placeholder="City, Country" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Website -->
                        <div>
                            <x-input-label for="website" :value="__('Company Website')" />
                            <x-text-input id="website" class="block mt-1 w-full" type="url" name="website" :value="old('website')" placeholder="https://example.com" />
                            <x-input-error :messages="$errors->get('website')" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div>
                            <x-input-label for="phone" :value="__('Phone Number')" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" placeholder="e.g. +1 (555) 123-4567" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Company Logo -->
                    <div class="mt-6">
                        <x-input-label for="employer_logo" :value="__('Company Logo')" />
                        <div class="mt-2 flex items-center">
                            <div id="logo-preview" class="hidden mr-4 h-16 w-16 border rounded-md overflow-hidden bg-gray-100 flex items-center justify-center">
                                <img id="logo-img" src="#" alt="Logo preview" class="h-full w-full object-contain">
                            </div>
                            <label class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span>Upload logo</span>
                                <input id="employer_logo" name="employer_logo" type="file" accept="image/*" class="sr-only" onchange="showPreview(event)">
                            </label>
                            <p class="text-xs text-gray-500 ml-3">PNG, JPG, GIF up to 2MB</p>
                        </div>
                        <x-input-error :messages="$errors->get('employer_logo')" class="mt-2" />
                    </div>

                    <!-- Company Description -->
                    <div class="mt-6">
                        <x-input-label for="description" :value="__('Company Description')" />
                        <textarea id="description" name="description" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Tell us about your company...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        <p class="text-xs text-gray-500 mt-1">This will be displayed on your company profile page</p>
                    </div>
                </div>

                <!-- Marketing opt-in -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="marketing" name="marketing" type="checkbox" class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500">
                    </div>
                    <label for="marketing" class="ml-2 text-sm text-gray-600">
                        I'd like to receive emails about new features, tips for finding great talent, and relevant industry updates.
                    </label>
                </div>

                <!-- Terms and Privacy -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500">
                    </div>
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        I agree to the <a href="#" class="text-purple-600 hover:underline">Terms of Service</a> and <a href="#" class="text-purple-600 hover:underline">Privacy Policy</a>
                    </label>
                </div>

                <div>
                    <x-primary-button class="w-full justify-center py-3 bg-purple-600 hover:bg-purple-700">
                        {{ __('Create Employer Account') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-6 text-center text-sm text-gray-600">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-purple-600 hover:text-purple-500">
            Sign in
        </a>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });

        function showPreview(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    document.getElementById('logo-img').src = e.target.result;
                    document.getElementById('logo-preview').classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-guest-layout>