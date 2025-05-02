<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Employer;

class EmployerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $employer = $user->employer;
        
        // Get active internships count
        $activeInternships = Internship::where('employer_id', $employer->id)
                            ->where('is_active', true)
                            ->count();
        
        // Get recent applications
        $recentApplications = Application::whereHas('internship', function($query) use ($employer) {
                            $query->where('employer_id', $employer->id);
                          })
                          ->with(['user', 'internship'])
                          ->latest()
                          ->take(5)
                          ->get();
        
        // Get active internships list
        $activeInternshipsList = Internship::where('employer_id', $employer->id)
                              ->where('is_active', true)
                              ->withCount('applications')
                              ->latest()
                              ->take(4)
                              ->get();
        
        // Get total applicants
        $totalApplicants = Application::whereHas('internship', function($query) use ($employer) {
                         $query->where('employer_id', $employer->id);
                       })
                       ->count();
        
        // Get pending applications
        $pendingApplications = Application::whereHas('internship', function($query) use ($employer) {
                             $query->where('employer_id', $employer->id);
                           })
                           ->where('status', 'pending')
                           ->count();
        
        // Get accepted applications
        $acceptedApplications = Application::whereHas('internship', function($query) use ($employer) {
                              $query->where('employer_id', $employer->id);
                            })
                            ->where('status', 'accepted')
                            ->count();
        
        return view('dashboard', compact(
            'recentApplications', 
            'activeInternshipsList', 
            'activeInternships',
            'totalApplicants',
            'pendingApplications',
            'acceptedApplications'
        ));
    }
    public function toggleInternshipStatus(Internship $internship)
    {
        // Check if the authenticated user is the employer of the internship
        $user = Auth::user();
               
        $isEmployerOwner = $internship->employer_id === $user->employer->id;
        if (!$isEmployerOwner) {
            abort(403, 'Unauthorized action. You do not own this internship.');
        }

        $internship->is_active = !$internship->is_active;
        $internship->save();

        $status = $internship->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Internship has been {$status}.");
    }
}
