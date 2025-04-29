<?php

namespace App\Http\Controllers;

use App\Models\AccountAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountAppealSubmitted;
use App\Mail\AccountAppealNotification;

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
    public function appeal(Request $request)
    {
        // Ensure user is logged in and suspended
        if (!Auth::check() || Auth::user()->is_active) {
            return redirect()->route('dashboard');
        }
        
        $validated = $request->validate([
            'appeal_reason' => 'required|string|min:20|max:5000',
            'additional_info' => 'nullable|string|max:2000',
            'acknowledge' => 'required|accepted',
        ]);
        
        // Create appeal record
        $appeal = new AccountAppeal([
            'user_id' => Auth::id(),
            'reason' => $validated['appeal_reason'],
            'additional_info' => $validated['additional_info'],
            'status' => 'pending', // pending, approved, rejected
        ]);
        
        $appeal->save();
        
        // Send email to user confirming appeal submission
        try {
            Mail::to(Auth::user()->email)->send(new AccountAppealSubmitted(Auth::user()));
            
            // Send notification to admins
            $admins = \App\Models\User::whereHas('admin')->get();
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new AccountAppealNotification(Auth::user(), $appeal));
            }
        } catch (\Exception $e) {
            // Log email error but continue
            \Log::error("Failed to send appeal email: " . $e->getMessage());
        }
        
        return back()->with('success', 'Your appeal has been submitted successfully. We will review it and respond within 1-2 business days.');
    }
}