<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome Back</h1>
            <p class="mt-2 text-gray-600">Sign in to your account to continue</p>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="p-6 sm:p-8">
                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" />
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <x-text-input id="email" class="block mt-1 w-full pl-10" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between">
                            <x-input-label for="password" :value="__('Password')" />
                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <x-text-input id="password" class="block mt-1 w-full pl-10 pr-10"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="••••••••" />
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" name="remember">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                            {{ __('Remember me') }}
                        </label>
                    </div>

                    <div>
                        <x-primary-button class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700">
                            {{ __('Sign in') }}
                        </x-primary-button>
                    </div>
                </form>

                <div class="mt-6 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <a href="#" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="#4285F4" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5.9c1.16 0 2.2.5 3.03 1.32L17.9 4.35C16.33 2.85 14.28 2 12 2 8.84 2 5.7 4.25 4.53 7.3L8.06 9.9c.75-2.3 2.9-4 5.94-4z" fill="#EA4335"></path>
                            <path d="M21.8 12.29c0-.78-.07-1.53-.2-2.25H12v4.25h5.92c-.26 1.39-1.04 2.58-2.21 3.37l3.47 2.69c2.01-1.86 3.17-4.6 3.17-7.83z" fill="#4285F4"></path>
                            <path d="M8.06 14.1c-.45 1.38-1.45 2.54-2.8 3.16l3.58 2.77c2.16-2 3.41-4.93 3.41-8.36 0-.1 0-.19-.01-.29H8.06v2.72z" fill="#FBBC05"></path>
                            <path d="M5.26 17.26c-2.75-2.75-2.75-7.21 0-9.96l-3.58-2.77c-4.2 4.2-4.2 11 0 15.32l3.58-2.59z" fill="#34A853"></path>
                        </svg>
                        Google
                    </a>

                    <a href="#" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="h-5 w-5 mr-2" fill="#1877F2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.2143 0H2.7857C1.24821 0 0 1.24821 0 2.7857V21.2143C0 22.7518 1.24821 24 2.7857 24H12.75V14.25H9.75V11.25H12.75V9C12.75 6.81964 14.3196 4.5 18 4.5C19.5 4.5 20.7589 4.71429 20.7589 4.71429L20.6786 7.5H18.75C17.1429 7.5 16.5 8.25 16.5 9.75V11.25H20.7857L20.5714 14.25H16.5V24H21.2143C22.7518 24 24 22.7518 24 21.2143V2.7857C24 1.24821 22.7518 0 21.2143 0Z"></path>
                        </svg>
                        Facebook
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center text-sm text-gray-600">
            Don't have an account yet?
            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                Create an account
            </a>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });
    </script>
</x-guest-layout>