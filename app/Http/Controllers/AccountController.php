<?php

namespace App\Http\Controllers;

use App\Models\AccountAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountAppealSubmitted;
use App\Mail\AccountAppealNotification;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    /**
     * Display suspended account page
     */
    public function suspended()
    {
        // If user is active, redirect them to home
        if (Auth::check() && Auth::user()->is_active) {
            return redirect()->route('dashboard');
        }
        
        return view('account.suspended');
    }
    
    /**
     * Process account suspension appeal
     */

    public function submitAppeal(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'appeal_reason' => 'required|string|min:20',
            'additional_info' => 'nullable|string',
            'acknowledge' => 'required|accepted',
        ]);
        
        $user = Auth::user();
        
        // Store the appeal in database
        $appeal = new AccountAppeal();
        $appeal->user_id = $user->id;
        $appeal->reason = $validated['appeal_reason'];
        $appeal->additional_info = $validated['additional_info'] ?? null;
        $appeal->status = 'pending';
        $appeal->save();


        // Send email notification to the user
        Mail::to($user->email)->queue(new AccountAppealSubmitted(
            $user, 
            $validated['appeal_reason'],
            $validated['additional_info'] ?? null
        ));

        // Also notify admin
        Mail::to(config('mail.admin_address', 'abdulazeezbrhomi@gmail.com'))->queue(new AccountAppealNotification($user, $appeal));
        
        return back()->with('success', 'Your appeal has been submitted successfully. We will review it within 1-2 business days.');
    }
}