<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Student Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your student profile details and preferences.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.student.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Education Level -->
        <div>
            <x-input-label for="education_level" :value="__('Education Level')" />
            <select id="education_level" name="education_level" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                @php
                    $levels = ['high_school' => 'High School', 'associate' => 'Associate Degree', 'bachelor' => 'Bachelor\'s Degree', 'master' => 'Master\'s Degree', 'phd' => 'PhD'];
                @endphp
                
                @foreach($levels as $value => $label)
                    <option value="{{ $value }}" {{ auth()->user()->student->education_level == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('education_level')" />
        </div>

        <!-- Institution -->
        <div>
            <x-input-label for="institution" :value="__('Institution')" />
            <x-text-input id="institution" name="institution" type="text" class="mt-1 block w-full" :value="old('institution', auth()->user()->student->institution)" required autofocus autocomplete="institution" />
            <x-input-error class="mt-2" :messages="$errors->get('institution')" />
        </div>

        <!-- Field of Study -->
        <div>
            <x-input-label for="field_of_study" :value="__('Field of Study')" />
            <x-text-input id="field_of_study" name="field_of_study" type="text" class="mt-1 block w-full" :value="old('field_of_study', auth()->user()->student->field_of_study)" autocomplete="field_of_study" />
            <x-input-error class="mt-2" :messages="$errors->get('field_of_study')" />
        </div>

        <!-- Graduation Date -->
        <div>
    <x-input-label for="graduation_date" :value="__('Expected Graduation Date')" />
    <x-text-input id="graduation_date" name="graduation_date" type="date" class="mt-1 block w-full" 
        :value="old('graduation_date', auth()->user()->student->graduation_date ? \Carbon\Carbon::parse(auth()->user()->student->graduation_date)->format('Y-m-d') : '')" />
    <x-input-error class="mt-2" :messages="$errors->get('graduation_date')" />
</div>  

        <!-- Skills -->
        <div>
            <x-input-label for="skills" :value="__('Skills (comma separated)')" />
            <x-text-input id="skills" name="skills" type="text" class="mt-1 block w-full" :value="old('skills', auth()->user()->student->skills)" autocomplete="skills" />
            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
        </div>

        <!-- Resume -->
        <div>
            <x-input-label for="resume" :value="__('Resume (PDF only)')" />
            <input type="file" id="resume" name="resume" class="mt-1 block w-full" accept="application/pdf">
            @if(auth()->user()->student->resume_path)
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Current resume: <a href="{{ Storage::url(auth()->user()->student->resume_path) }}" class="text-blue-600 hover:underline" target="_blank">View</a>
                </p>
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('resume')" />
        </div>

        <!-- Profile Photo -->
        <div>
            <x-input-label for="profile_photo" :value="__('Profile Photo')" />
            <input type="file" id="profile_photo" name="profile_photo" class="mt-1 block w-full" accept="image/jpeg,image/png,image/jpg">
            @if(auth()->user()->student->profile_photo_path)
                <div class="mt-2">
                    <img src="{{ Storage::url(auth()->user()->student->profile_photo_path) }}" alt="Profile Photo" class="h-20 w-20 object-cover rounded-full">
                </div>
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <!-- LinkedIn URL -->
        <div>
            <x-input-label for="linkedin_url" :value="__('LinkedIn URL')" />
            <x-text-input id="linkedin_url" name="linkedin_url" type="url" class="mt-1 block w-full" :value="old('linkedin_url', auth()->user()->student->linkedin_url)" autocomplete="linkedin_url" />
            <x-input-error class="mt-2" :messages="$errors->get('linkedin_url')" />
        </div>

        <!-- GitHub URL -->
        <div>
            <x-input-label for="github_url" :value="__('GitHub URL')" />
            <x-text-input id="github_url" name="github_url" type="url" class="mt-1 block w-full" :value="old('github_url', auth()->user()->student->github_url)" autocomplete="github_url" />
            <x-input-error class="mt-2" :messages="$errors->get('github_url')" />
        </div>

        <!-- Portfolio URL -->
        <div>
            <x-input-label for="portfolio_url" :value="__('Portfolio URL')" />
            <x-text-input id="portfolio_url" name="portfolio_url" type="url" class="mt-1 block w-full" :value="old('portfolio_url', auth()->user()->student->portfolio_url)" autocomplete="portfolio_url" />
            <x-input-error class="mt-2" :messages="$errors->get('portfolio_url')" />
        </div>

        <!-- Bio -->
        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="4">{{ old('bio', auth()->user()->student->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', auth()->user()->student->phone)" autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'student-profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>