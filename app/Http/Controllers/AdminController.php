<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Employer;
use App\Models\Internship;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Auth middleware should be applied in routes file:
        // Route::middleware('auth')->group(function () {
        //     Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
        //     // other admin routes...
        // });
    }

    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        // Authorization check
        if (!Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $stats = [
            'users' => User::count(),
            'employers' => Employer::count(),
            'internships' => Internship::count(),
            'applications' => Application::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
    
    /**
     * Display user management page
     */
    public function users()
    {
        // Authorization check
        if (!Gate::allows('manage-users')) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::with(['admin', 'employer'])->paginate(15);
        return view('admin.users', compact('users'));
    }
    
    /**
     * Promote a user to admin
     */
    public function promote(User $user)
    {
        // Authorization check
        if (!Gate::allows('promote-users')) {
            abort(403, 'Unauthorized action.');
        }

        // Check if already admin
        if ($user->isAdmin()) {
            return back()->with('info', 'User is already an admin.');
        }
        
        DB::beginTransaction();
        
        try {
            // If user is an employer, remove employer record
            if ($user->employer) {
                // Log the employer data being removed
                Log::info('Removing employer data during admin promotion', [
                    'user_id' => $user->id,
                    'employer_id' => $user->employer->id,
                ]);
                
                $user->employer->delete();
            }
            
            // Create admin record
            Admin::create([
                'user_id' => $user->id,
                'role' => 'admin',
            ]);
            
            DB::commit();
            return back()->with('success', 'User promoted to admin successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to promote user to admin', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            
            return back()->with('error', 'Failed to promote user to admin.');
        }
    }
    
    /**
     * Remove admin privileges
     */
    public function demote(User $user)
    {
        // Authorization check
        if (!Gate::allows('demote-admins', $user)) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($user->admin) {
            $user->admin->delete();
            return back()->with('success', 'Admin privileges removed successfully.');
        }
        
        return back()->with('info', 'User is not an admin.');
    }
}