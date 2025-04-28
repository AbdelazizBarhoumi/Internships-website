<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isEmployer()) {
            return redirect()->route('employer.dashboard');
        } else {
            // Applicant dashboard
            return view('dashboard.applicant');
        }
    }
    
    public function employer()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Ensure only employers can access
        if (!$user->isEmployer()) {
            abort(403);
        }

        return view('dashboard.employer');
    }
}