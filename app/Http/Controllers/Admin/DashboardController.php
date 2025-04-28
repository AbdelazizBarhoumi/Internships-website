<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\User;
use App\Models\Employer;
use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'employers' => Employer::count(),
            'internships' => Internship::count(),
            'applications' => Application::count(),
            'pendingApplications' => Application::where('status', 'pending')->count(),
            'activeInternships' => Internship::whereDate('deadline', '>=', now())->count(),
            'featuredInternships' => Internship::where('featured', true)->count(),
        ];

        $latestUsers = User::latest()->take(5)->get();
        $latestInternships = Internship::with('employer')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'latestUsers', 'latestInternships'));
    }
}