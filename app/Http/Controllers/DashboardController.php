<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the appropriate dashboard based on user type
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isEmployer()) {
            return redirect()->route('employer.dashboard');
        } else {
            return $this->studentDashboard();
        }
    }
    
    /**
     * Display the student dashboard.
     *
     * @return \Illuminate\View\View
     */
    protected function studentDashboard()
    {
        $user = Auth::user();
        $student = $user->student;
        
        // Get applications directly using the user ID
        $applications = Application::where('user_id', $user->id)
            ->with(['internship.employer'])
            ->latest()
            ->get();
        // Calculate profile completion        
        return view('dashboard', [
            'student' => $student,
            'applications' => $applications,
        ]);
    }
    
    /**
     * Calculate the profile completion percentage.
     *
     * @param \App\Models\Student $student
     * @return array
     */
   
}