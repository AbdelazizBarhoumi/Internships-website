<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Employer;
use App\Models\Internship;
use App\Models\Application;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Authentication will be handled in the routes file
    }

    /**
     * Display admin dashboard with enhanced analytics
     */
    public function dashboard()
    {
        // Authorization check
        if (!Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Basic stats
        $stats = [
            'users' => User::count(),
            'employers' => Employer::count(),
            'internships' => Internship::count(),
            'applications' => Application::count(),
            'admin_count' => Admin::count(),
        ];

        // Recent activity
        $recentInternships = Internship::with('employer')->latest()->take(5)->get();
        $recentApplications = Application::with(['user', 'internship'])->latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        // Analytics data - Using SQLite's strftime function
        $monthlyStats = [
            'applications' => Application::selectRaw('COUNT(*) as count, strftime(\'%m\', created_at) as month')
                ->whereRaw('strftime(\'%Y\', created_at) = ?', [date('Y')])
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray(),
            'internships' => Internship::selectRaw('COUNT(*) as count, strftime(\'%m\', created_at) as month')
                ->whereRaw('strftime(\'%Y\', created_at) = ?', [date('Y')])
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray(),
            'users' => User::selectRaw('COUNT(*) as count, strftime(\'%m\', created_at) as month')
                ->whereRaw('strftime(\'%Y\', created_at) = ?', [date('Y')])
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray(),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recentInternships',
            'recentApplications',
            'recentUsers',
            'monthlyStats'
        ));
    }

    /**
     * Display user management page with enhanced filtering
     */
    public function users(Request $request)
    {
        if (!Gate::allows('manage-users')) {
            abort(403, 'Unauthorized action.');
        }

        $query = User::with(['admin', 'employer']);

        // Filter by user type
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'admins':
                    $query->whereHas('admin');
                    break;
                case 'employers':
                    $query->whereHas('employer');
                    break;
                case 'regular':
                    $query->whereDoesntHave('admin')->whereDoesntHave('employer');
                    break;
            }
        }

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)
            ->appends($request->all());

        return view('admin.users', compact('users'));
    }

    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        if (!Gate::allows('manage-users')) {
            abort(403, 'Unauthorized action.');
        }

        $user->load('admin', 'employer');

        // Get related data based on user type
        $userData = [];

        if ($user->employer) {
            $userData['internships'] = Internship::where('employer_id', $user->employer->id)
                ->withCount('applications')
                ->get();
        } else {
            $userData['applications'] = Application::where('user_id', $user->id)
                ->with('internship')
                ->get();
        }

        return view('admin.user-details', compact('user', 'userData'));
    }

    /**
     * Promote a user to admin
     */
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

            // Delete user's applications if any
            $applicationCount = Application::where('user_id', $user->id)->count();

            if ($applicationCount > 0) {
                // Log the applications being deleted
                Log::info('Removing user applications during admin promotion', [
                    'user_id' => $user->id,
                    'application_count' => $applicationCount,
                ]);

                Application::where('user_id', $user->id)->delete();
            }

            // Create admin record
            Admin::create([
                'user_id' => $user->id,
                'role' => 'admin',
            ]);

            DB::commit();

            return back()->with('success', "User promoted to admin successfully. Removed {$applicationCount} application(s).");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to promote user to admin', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to promote user to admin: ' . $e->getMessage());
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

    /**
     * Toggle user account status (active/suspended)
     */
    public function toggleUserStatus(User $user)
    {
        if (!Gate::allows('manage-users')) {
            abort(403, 'Unauthorized action.');
        }

        // Don't allow suspending yourself
        if (Auth::user()->id === $user->id) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activated' : 'suspended';
        return back()->with('success', "User account has been {$status}.");
    }

    /**
     * Display all internships with management options
     */
    public function internships(Request $request)
    {
        if (!Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $query = Internship::with('employer', 'tags')->withCount('applications');

        // Filter by active status if requested
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by search term
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('location', 'like', "%{$searchTerm}%")
                    ->orWhereHas('employer', function ($eq) use ($searchTerm) {
                        $eq->where('company_name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        $internships = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($request->all());

        return view('admin.internships', compact('internships'));
    }

    /**
     * Show specific internship details
     */
    public function showInternship(Internship $internship)
    {
        if (!Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $internship->load('employer', 'tags', 'applications.user');

        return view('admin.internship-details', compact('internship'));
    }

    /**
     * Toggle internship approval status
     */
    public function toggleInternshipStatus(Internship $internship)
    {
        if (!Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $internship->is_active = !$internship->is_active;
        $internship->save();

        $status = $internship->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Internship has been {$status}.");
    }

    /**
     * Delete an internship
     */
    public function deleteInternship(Internship $internship)
    {
        if (!Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $title = $internship->title;
        $internship->delete();

        return redirect()->route('admin.internships')
            ->with('success', "Internship '{$title}' has been deleted.");
    }

    /**
     * Display all applications
     */
    public function applications(Request $request)
    {
        if (!Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $query = Application::with(['user', 'internship.employer']);

        // Filter by status if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('user', function ($uq) use ($searchTerm) {
                    $uq->where('name', 'like', "%{$searchTerm}%")
                        ->orWhere('email', 'like', "%{$searchTerm}%");
                })->orWhereHas('internship', function ($iq) use ($searchTerm) {
                    $iq->where('title', 'like', "%{$searchTerm}%");
                });
            });
        }

        $applications = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($request->all());

        return view('admin.applications', compact('applications'));
    }

    /**
     * Show application details
     */
    public function showApplication(Application $application)
    {
        if (!Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $application->load('user', 'internship.employer');

        return view('admin.application-details', compact('application'));
    }

    /**
     * Update application status
     */
    public function updateApplicationStatus(Request $request, Application $application)
    {
        if (!Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);


        if (isset($validated['admin_notes'])) {
            $application->admin_notes = $validated['admin_notes'];
        }

        $application->save();

        return back()->with('success', 'Application Notes updated successfully.');
    }

    /**
     * Show system settings
     */
    public function settings()
    {
        if (!Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Get settings from database
        $settingsData = DB::table('settings')->get();

        $settings = [];
        foreach ($settingsData as $setting) {
            $settings[$setting->key] = json_decode($setting->value, true);
        }

        // Add any missing settings with defaults
        $defaultSettings = [
            'site_name' => config('app.name'),
            'registration_open' => true,
            'employer_approval_required' => true,
            'max_internships_per_employer' => 10,
            'max_applications_per_user' => 5,
        ];

        foreach ($defaultSettings as $key => $value) {
            if (!array_key_exists($key, $settings)) {
                $settings[$key] = $value;
            }
        }

        return view('admin.settings', compact('settings'));
    }

    /**
     * Update system settings
     */
    public function updateSettings(Request $request)
    {
        if (!Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'registration_open' => 'boolean',
            'employer_approval_required' => 'boolean',
            'max_internships_per_employer' => 'integer|min:1|max:100',
            'max_applications_per_user' => 'integer|min:1|max:20',
        ]);

        // Handle checkbox fields that aren't submitted when unchecked
        if (!isset($validated['registration_open'])) {
            $validated['registration_open'] = false;
        }

        if (!isset($validated['employer_approval_required'])) {
            $validated['employer_approval_required'] = false;
        }

        // Save to database
        foreach ($validated as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => json_encode($value), 'updated_at' => now()]
            );
        }

        // Update app name in config for current request
        config(['app.name' => $validated['site_name']]);

        return back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Clear various application caches
     */
    public function clearCache($type)
    {
        if (!Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }

        switch ($type) {
            case 'app':
                Artisan::call('cache:clear');
                $message = 'Application cache cleared successfully.';
                break;
            case 'view':
                Artisan::call('view:clear');
                $message = 'View cache cleared successfully.';
                break;
            case 'route':
                Artisan::call('route:clear');
                $message = 'Route cache cleared successfully.';
                break;
            case 'config':
                Artisan::call('config:clear');
                $message = 'Configuration cache cleared successfully.';
                break;
            default:
                return back()->with('error', 'Invalid cache type specified.');
        }

        return back()->with('success', $message);
    }

    /**
     * Export database backup
     */
    public function exportDatabase()
    {
        if (!Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }

        // This is a simplified example, in production you'd want to use a proper
        // database backup library or package

        $filename = 'backup-' . date('Y-m-d-His') . '.sql';

        // Use mysqldump command for MySQL
        $command = sprintf(
            'mysqldump --user=%s --password=%s %s > %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            storage_path('app/' . $filename)
        );

        exec($command);

        return response()->download(storage_path('app/' . $filename))->deleteFileAfterSend();
    }

}