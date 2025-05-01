<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Display the student registration view.
     */
    public function createStudent(): View
    {
        return view('auth.register-student');
    }

    /**
     * Display the employer registration view.
     */
    public function createEmployer(): View
    {
        return view('auth.register-employer');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Common user validation for all user types
        $userAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()],
            'terms' => ['required', 'accepted'],
            'newsletter_subscribed' => ['sometimes', 'boolean'],
            'user_type' => ['required', 'in:student,employer'],
        ]);

        // Create the base user
        $user = User::create([
            'name' => $userAttributes['name'],
            'email' => $userAttributes['email'],
            'password' => Hash::make($userAttributes['password']),
            'newsletter_subscribed' => $request->boolean('newsletter_subscribed', false),
            'role' => $request->user_type, // Set the role based on user_type
            'is_active' => true,
        ]);

        // Handle user type specific registration
        try {
            if ($request->user_type === 'employer') {
                $this->registerEmployer($request, $user);
            } else {
                $this->registerStudent($request, $user);
            }

            // Trigger registered event for verification emails, etc.
            event(new Registered($user));

            // Log the user in
            Auth::login($user);

            // Redirect with success message
            return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome to our platform.');

        } catch (\Exception $e) {
            // If any error occurs, delete the user and redirect back with error
            if ($user && $user->exists) {
                $user->delete();
            }

            Log::error('Registration failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Registration failed. Please try again: ' . $e->getMessage());
        }
    }

    /**
     * Handle direct student registration.
     */
    public function storeStudent(Request $request): RedirectResponse
    {
        // Validate user fields
        $userValidation = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()],
            'terms' => ['required', 'accepted'],
        ];

        // Validate student fields
        $studentValidation = [
            'education_level' => ['required', 'string', 'in:high_school,associate,bachelor,master,phd'],
            'institution' => ['required', 'string', 'max:255'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'graduation_date' => ['nullable', 'date'],
            'skills' => ['nullable', 'string', 'max:500'],
            'resume' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // 5MB max
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];

        // Merge validations
        $validatedData = $request->validate(array_merge($userValidation, $studentValidation));

        try {
            // Create the user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'student',
                'is_active' => true,
            ]);

            // Register the student
            $this->registerStudent($request, $user);

            // Trigger registered event
            event(new Registered($user));

            // Log the user in
            Auth::login($user);

            // Redirect to dashboard
            return redirect()->route('dashboard')->with('success', 'Student registration successful!');
        } catch (\Exception $e) {
            // Clean up if there's an error
            Log::error('Student registration failed: ' . $e->getMessage());

            if (isset($user) && $user->exists) {
                $user->delete();
            }

            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Registration failed. Please try again: ' . $e->getMessage());
        }
    }

    /**
     * Handle direct employer registration.
     */
    public function storeEmployer(Request $request): RedirectResponse
    {
        // Validate user fields
        $userValidation = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()],
            'terms' => ['required', 'accepted'],
        ];

        // Validate employer fields
        $employerValidation = [
            'employer_name' => ['required', 'string', 'max:255'],
            'employer_email' => ['required', 'email', 'max:255', 'unique:employers,email'],
            'employer_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'industry' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'website' => ['nullable', 'url', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company_size' => ['nullable', 'string', 'max:50'],
            'year_founded' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
        ];

        // Merge validations
        $validatedData = $request->validate(array_merge($userValidation, $employerValidation));

        try {
            // Create the user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'employer',
                'is_active' => true,
            ]);

            // Register the employer
            $this->registerEmployer($request, $user);

            // Trigger registered event
            event(new Registered($user));

            // Log the user in
            Auth::login($user);

            // Redirect to dashboard
            return redirect()->route('dashboard')->with('success', 'Employer registration successful!');
        } catch (\Exception $e) {
            // Clean up if there's an error
            Log::error('Employer registration failed: ' . $e->getMessage());

            if (isset($user) && $user->exists) {
                $user->delete();
            }

            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Registration failed. Please try again: ' . $e->getMessage());
        }
    }

    /**
     * Handle employer-specific registration logic
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    protected function registerEmployer(Request $request, User $user): void
    {
        // Validate employer fields
        $employerAttributes = $request->validate([
            'employer_name' => ['required', 'string', 'max:255'],
            'employer_email' => ['required', 'email', 'max:255'],
            'employer_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'industry' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'website' => ['nullable', 'url', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company_size' => ['nullable', 'string', 'max:50'],
            'year_founded' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
        ]);

        // Handle logo upload
        $logoPath = null;
        if ($request->hasFile('employer_logo')) {
            $logoPath = $request->file('employer_logo')
                ->store('employer_logos', 'public');
        }

        // Create employer record - adapt field names to match your schema
        $user->employer()->create([
            'employer_name' => $employerAttributes['employer_name'],
            'employer_email' => $employerAttributes['employer_email'],
            'employer_logo' => $logoPath,
            'industry' => $employerAttributes['industry'] ?? null,
            'location' => $employerAttributes['location'] ?? null,
            'description' => $employerAttributes['description'] ?? null,
            'website' => $employerAttributes['website'] ?? null,
            'phone' => $employerAttributes['phone'] ?? null,
        ]);
    }

    /**
     * Handle student-specific registration logic
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    protected function registerStudent(Request $request, User $user): void
    {
        // Validate student fields
        $studentAttributes = $request->validate([
            'education_level' => ['required', 'string', 'in:high_school,associate,bachelor,master,phd'],
            'institution' => ['required', 'string', 'max:255'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'graduation_date' => ['nullable', 'date'],
            'skills' => ['nullable', 'string', 'max:500'],
            'resume' => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // 5MB max
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // Handle resume upload
        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')
                ->store('resumes', 'public');
        }
        
        // Handle profile photo with debug information
        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            try {
                $profilePhotoPath = $request->file('profile_photo')
                    ->store('profile_photos', 'public');
                
                // Debug to check if file was stored
                Log::info('Profile photo stored: ' . $profilePhotoPath);
            } catch (\Exception $e) {
                Log::error('Failed to store profile photo: ' . $e->getMessage());
            }
        } else {
            Log::info('No profile photo submitted');
        }

        // Create student record with verification
        try {
            $student = $user->student()->create([
                'education_level' => $studentAttributes['education_level'],
                'institution' => $studentAttributes['institution'],
                'field_of_study' => $studentAttributes['field_of_study'] ?? null,
                'graduation_date' => $studentAttributes['graduation_date'] ?? null, 
                'skills' => $studentAttributes['skills'] ?? null,
                'linkedin_url' => $studentAttributes['linkedin_url'] ?? null,
                'github_url' => $studentAttributes['github_url'] ?? null,
                'portfolio_url' => $studentAttributes['portfolio_url'] ?? null,
                'bio' => $studentAttributes['bio'] ?? null,
                'profile_photo_path' => $profilePhotoPath,
                'phone' => $studentAttributes['phone'] ?? null,
                'resume_path' => $resumePath,
            ]);
            
            // Log successful creation
            Log::info('Student record created with profile_photo_path: ' . $profilePhotoPath);
        } catch (\Exception $e) {
            Log::error('Failed to create student record: ' . $e->getMessage());
            throw $e;  // Re-throw to handle in the calling method
        }
    }
}