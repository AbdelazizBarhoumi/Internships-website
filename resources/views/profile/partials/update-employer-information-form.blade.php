<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Employer Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your company details and recruiting preferences.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.employer.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Employer Name -->
        <div>
            <x-input-label for="employer_name" :value="__('Company Name')" />
            <x-text-input id="employer_name" name="employer_name" type="text" class="mt-1 block w-full" :value="old('employer_name', auth()->user()->employer->employer_name)" required autofocus autocomplete="employer_name" />
            <x-input-error class="mt-2" :messages="$errors->get('employer_name')" />
        </div>

        <!-- Business Email -->
        <div>
            <x-input-label for="employer_email" :value="__('Business Email')" />
            <x-text-input id="employer_email" name="employer_email" type="email" class="mt-1 block w-full" :value="old('employer_email', auth()->user()->employer->employer_email)" required autocomplete="employer_email" />
            <x-input-error class="mt-2" :messages="$errors->get('employer_email')" />
        </div>

        <!-- Company Logo -->
        <div>
            <x-input-label for="employer_logo" :value="__('Company Logo')" />
            <input type="file" id="employer_logo" name="employer_logo" class="mt-1 block w-full" accept="image/jpeg,image/png,image/jpg,image/gif">
            @if(auth()->user()->employer->employer_logo)
                <div class="mt-2">
                    <img src="{{ Storage::url(auth()->user()->employer->employer_logo) }}" alt="Company Logo" class="h-20 object-contain">
                </div>
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('employer_logo')" />
        </div>

        <!-- Industry -->
        <div>
            <x-input-label for="industry" :value="__('Industry')" />
            <x-text-input id="industry" name="industry" type="text" class="mt-1 block w-full" :value="old('industry', auth()->user()->employer->industry)" autocomplete="industry" />
            <x-input-error class="mt-2" :messages="$errors->get('industry')" />
        </div>

        <!-- Location -->
        <div>
            <x-input-label for="location" :value="__('Location')" />
            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', auth()->user()->employer->location)" autocomplete="location" />
            <x-input-error class="mt-2" :messages="$errors->get('location')" />
        </div>

        <!-- Description -->
        <div>
            <x-input-label for="description" :value="__('Company Description')" />
            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="4">{{ old('description', auth()->user()->employer->description) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <!-- Website -->
        <div>
            <x-input-label for="website" :value="__('Website')" />
            <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" :value="old('website', auth()->user()->employer->website)" autocomplete="website" />
            <x-input-error class="mt-2" :messages="$errors->get('website')" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Contact Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', auth()->user()->employer->phone)" autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

    


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'employer-profile-updated')
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