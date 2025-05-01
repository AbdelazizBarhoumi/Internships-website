<x-guest-layout>
    <div class="mb-6 flex items-center">
        <a href="{{ route('register') }}" class="flex items-center text-sm text-gray-600 hover:text-indigo-600 transition-colors mr-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back
        </a>
        <h2 class="text-2xl font-bold text-gray-900">Student Registration</h2>
    </div>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 max-w-3xl mx-auto">
        <div class="p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-6 pb-6 border-b">
                <div class="p-4 bg-blue-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Join as a Student</h3>
                    <p class="mt-1 text-sm text-gray-600">Fill in your details to create your student account and start applying for internships</p>
                </div>
            </div>

            <form method="POST" action="{{ route('register.student.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="border-b pb-6 mb-6">
            <h4 class="font-medium text-gray-900 mb-4">Account Information</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="your.email@example.com" />
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

                <!-- Phone -->
                <div>
                    <x-input-label for="phone" :value="__('Phone Number')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" placeholder="e.g. (555) 123-4567" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
                
                <!-- Profile Photo - Modified to use avatar field instead -->
                <div>
                    <x-input-label for="profile_photo" :value="__('Profile Photo')" />
                    <div class="mt-1 flex items-center">
                        <div id="photo-preview" class="hidden mr-3 h-12 w-12 rounded-full overflow-hidden bg-gray-100"></div>
                        <label class="block">
                            <span class="sr-only">Choose profile photo</span>
                            <input type="file" id="profile_photo" name="profile_photo" accept="image/jpeg,image/png,image/jpg" 
                                class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100"
                                onchange="showPhotoPreview(event)"
                            />
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">JPG or PNG up to 2MB</p>
                    <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                </div>
            </div>
        </div>

                <div class="border-b pb-6 mb-6">
                    <h4 class="font-medium text-gray-900 mb-4">Education Information</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Education Level -->
                        <div>
                            <x-input-label for="education_level" :value="__('Education Level')" />
                            <select id="education_level" name="education_level" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="">Select your education level</option>
                                <option value="high_school" {{ old('education_level') == 'high_school' ? 'selected' : '' }}>High School</option>
                                <option value="associate" {{ old('education_level') == 'associate' ? 'selected' : '' }}>Associate Degree</option>
                                <option value="bachelor" {{ old('education_level') == 'bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                                <option value="master" {{ old('education_level') == 'master' ? 'selected' : '' }}>Master's Degree</option>
                                <option value="phd" {{ old('education_level') == 'phd' ? 'selected' : '' }}>Ph.D.</option>
                            </select>
                            <x-input-error :messages="$errors->get('education_level')" class="mt-2" />
                        </div>

                        <!-- Institution -->
                        <div>
                            <x-input-label for="institution" :value="__('Educational Institution')" />
                            <x-text-input id="institution" class="block mt-1 w-full" type="text" name="institution" :value="old('institution')" required placeholder="University or College name" />
                            <x-input-error :messages="$errors->get('institution')" class="mt-2" />
                        </div>

                        <!-- Field of Study -->
                        <div>
                            <x-input-label for="field_of_study" :value="__('Field of Study')" />
                            <x-text-input id="field_of_study" class="block mt-1 w-full" type="text" name="field_of_study" :value="old('field_of_study')" placeholder="e.g. Computer Science, Marketing..." />
                            <x-input-error :messages="$errors->get('field_of_study')" class="mt-2" />
                        </div>

                        <!-- Graduation Date -->
                        <div>
                            <x-input-label for="graduation_date" :value="__('Expected Graduation Date')" />
                            <x-text-input id="graduation_date" class="block mt-1 w-full" type="date" name="graduation_date" :value="old('graduation_date')" />
                            <x-input-error :messages="$errors->get('graduation_date')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">When do you expect to graduate?</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium text-gray-900 mb-4">Professional Information <span class="text-xs text-gray-500">(Optional)</span></h4>
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Resume Upload -->
                        <div>
                            <x-input-label for="resume" :value="__('Resume/CV')" />
                            <div class="mt-1 flex items-center">
                                <label class="block w-full">
                                    <span class="sr-only">Choose resume file</span>
                                    <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" 
                                        class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100"
                                    />
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Upload your resume (PDF, DOC, or DOCX up to 5MB)</p>
                            <x-input-error :messages="$errors->get('resume')" class="mt-2" />
                            <div id="resume-selected" class="hidden mt-2 text-sm text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span id="resume-filename">File selected</span>
                            </div>
                        </div>

                        <!-- Skills -->
                        <div>
                            <x-input-label for="skills" :value="__('Skills')" />
                            <textarea id="skills" name="skills" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="List your skills separated by commas (e.g. Python, JavaScript, Data Analysis)">{{ old('skills') }}</textarea>
                            <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                        </div>

                        <!-- Bio -->
                        <div>
                            <x-input-label for="bio" :value="__('Brief Bio')" />
                            <textarea id="bio" name="bio" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Tell us a bit about yourself...">{{ old('bio') }}</textarea>
                            <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">You can complete your profile later with more details</p>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <!-- LinkedIn URL -->
                            <div>
                                <x-input-label for="linkedin_url" :value="__('LinkedIn Profile')" />
                                <x-text-input id="linkedin_url" class="block mt-1 w-full" type="url" name="linkedin_url" :value="old('linkedin_url')" placeholder="https://linkedin.com/in/username" />
                                <x-input-error :messages="$errors->get('linkedin_url')" class="mt-2" />
                            </div>

                            <!-- GitHub URL -->
                            <div>
                                <x-input-label for="github_url" :value="__('GitHub Profile')" />
                                <x-text-input id="github_url" class="block mt-1 w-full" type="url" name="github_url" :value="old('github_url')" placeholder="https://github.com/username" />
                                <x-input-error :messages="$errors->get('github_url')" class="mt-2" />
                            </div>

                            <!-- Portfolio URL -->
                            <div>
                                <x-input-label for="portfolio_url" :value="__('Portfolio Website')" />
                                <x-text-input id="portfolio_url" class="block mt-1 w-full" type="url" name="portfolio_url" :value="old('portfolio_url')" placeholder="https://yourportfolio.com" />
                                <x-input-error :messages="$errors->get('portfolio_url')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms and Privacy -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    </div>
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        I agree to the <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Terms of Service</a> and <a href="{{ route('home') }}" class="text-blue-600 hover:underline">Privacy Policy</a>
                    </label>
                </div>

                <div>
            <x-primary-button class="w-full justify-center py-3 bg-blue-600 hover:bg-blue-700">
                {{ __('Create Student Account') }}
            </x-primary-button>
        </div>
    </form>
        </div>
    </div>

    <div class="mt-6 text-center text-sm text-gray-600">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
            Sign in
        </a>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });

        // Resume file selection
        document.getElementById('resume').addEventListener('change', function() {
            const fileInput = this;
            const resumeSelected = document.getElementById('resume-selected');
            const resumeFilename = document.getElementById('resume-filename');
            
            if (fileInput.files && fileInput.files[0]) {
                const fileName = fileInput.files[0].name;
                resumeFilename.textContent = fileName;
                resumeSelected.classList.remove('hidden');
            } else {
                resumeSelected.classList.add('hidden');
            }
        });

        // Profile photo preview - Updated to use avatar
        function showPhotoPreview(event) {
            const input = event.target;
            const preview = document.getElementById('photo-preview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.style.backgroundImage = `url(${e.target.result})`;
                    preview.style.backgroundSize = 'cover';
                    preview.style.backgroundPosition = 'center';
                    preview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-guest-layout>