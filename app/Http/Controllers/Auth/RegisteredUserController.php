<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $userAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()],
            'terms' => ['required', 'accepted'],
        ]);
        $employerAttributes = $request->validate([
            'employer_name' => ['required', 'string', 'max:255'],
            'employer_email' => ['required', 'string', 'email', 'max:255'],
            'employer_logo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = User::create($userAttributes);
        $logoPath = $request->hasFile('employer_logo') 
            ? $request->file('employer_logo')->store('logos') 
            : null;

        $user->employer()->create([
            'employer_name' => $request->employer_name,
            'employer_email' => $request->employer_email,
            'employer_logo' => $logoPath,
        ]);
        event(new Registered($user));

        Auth::login($user);

        return redirect('/')->with('success', value: 'Registration successful!');
    }
}
