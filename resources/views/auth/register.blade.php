<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-forms.divider />

        <!-- Employer Name -->
        <div class="mt-4">
            <x-input-label for="employer_name" :value="__('Employer Name')" />
            <x-text-input id="employer_name" class="block mt-1 w-full" type="text" name="employer_name"
                :value="old('employer_name')" required autofocus autocomplete="employer_name" />
            <x-input-error :messages="$errors->get('employer_name')" class="mt-2" />
        </div>

        <!-- Employer Email Address -->
        <div class="mt-4">
            <x-input-label for="employer_email" :value="__('Employer Email')" />
            <x-text-input id="employer_email" class="block mt-1 w-full" type="email" name="employer_email" :value="old('employer_email')" required
                autocomplete="employer_email" />
            <x-input-error :messages="$errors->get('employer_email')" class="mt-2" />
        </div>


        <!-- Employer Logo Address -->
        <div class="mt-4">
            <x-input-label for="employer_logo" :value="__('Employer Logo')" />
            <x-forms.input name="employer_logo" label="Employer Logo" type="file" />


            <x-input-error :messages="$errors->get('employer_logo')" class="mt-2" />
        </div>

        <x-forms.divider />


        <!-- Terms Address -->
        <div class="mt-4 flex items-center justify-start">
            <input name="terms" label="I agree to the terms and conditions" type="checkbox" required />
            <x-input-label for="terms" class="ms-2" :value="__('I agree to the terms and conditions')" />
            <x-input-error :messages="$errors->get('terms')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>