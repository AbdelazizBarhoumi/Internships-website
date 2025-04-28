<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApplicationController extends Controller
{
    /**
     * Show application form for an internship
     */
    public function create(Internship $internship)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to apply for internships.');
        }

        // Check if user has already applied
        $existingApplication = Application::where('user_id', Auth::id())
            ->where('internship_id', $internship->id)
            ->first();

        if ($existingApplication) {
            return redirect()->route('internships.show', $internship)
                ->with('error', 'You have already applied for this internship.');
        }

        return view('applications.create', compact('internship'));
    }

    /**
     * Store a new application
     */
    public function store(Request $request, Internship $internship)
    {
        // Validate form input
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'availability' => 'required|date|after:today',
            'education' => 'required|in:high_school,associate,bachelor,master,phd',
            'institution' => 'required|string|max:255',
            'skills' => 'required|string',
            'resume' => 'required|file|mimes:pdf|max:2048',
            'cover_letter' => 'nullable|string',
            'transcript' => 'nullable|file|mimes:pdf|max:2048',
            'why_interested' => 'required|string',
        ]);

        // Handle file uploads
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        $transcriptPath = null;
        if ($request->hasFile('transcript')) {
            $transcriptPath = $request->file('transcript')->store('transcripts', 'public');
        }

        // Create application
        $application = new Application([
            'user_id' => Auth::id(),
            'internship_id' => $internship->id,
            'phone' => $validated['phone'],
            'availability' => $validated['availability'],
            'education' => $validated['education'],
            'institution' => $validated['institution'],
            'skills' => $validated['skills'],
            'resume_path' => $resumePath,
            'cover_letter' => $validated['cover_letter'],
            'transcript_path' => $transcriptPath,
            'why_interested' => $validated['why_interested'],
            'status' => 'pending'
        ]);

        $application->save();

        return redirect()->route('dashboard')
            ->with('success', 'Your application for "' . $internship->title . '" has been submitted successfully!');
    }

    /**
     * List applications (admin/employer only)
     */
    public function index(Request $request)
    {
        // Check for employer or admin accessAuth::user()->employer
        if (!Auth::user()->isEmployer()) {
            abort(403, 'You do not have permission to view this page');
        }

        $query = Application::query()->with(['user', 'internship']);

        // Filter by employer's internships
        $query->whereHas('internship', function ($q) {
            $q->where('employer_id', Auth::user()->employer->id);
        });

        // Filter by status if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by internship if provided
        if ($request->has('internship_id') && !empty($request->internship_id)) {
            $query->where('internship_id', $request->internship_id);
        }

        $applications = $query->latest()->paginate(20);

        // Get status counts for statistics
        // Create a base query that filters by employer's internships
        $baseQuery = Application::query()->whereHas('internship', function ($q) {
            $q->where('employer_id', Auth::user()->employer->id);
        });

        // Apply filters for the main listing query
        $query = clone $baseQuery;

        // Filter by status if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by internship if provided
        if ($request->has('internship_id') && !empty($request->internship_id)) {
            $query->where('internship_id', $request->internship_id);
        }

        // Get the paginated results for display
        $applications = $query->with(['user', 'internship'])->latest()->paginate(20);

        // Get status counts using separate queries
        $pendingCount = (clone $baseQuery)->where('status', 'pending')->count();
        $reviewingCount = (clone $baseQuery)->where('status', 'reviewing')->count();
        $interviewedCount = (clone $baseQuery)->where('status', 'interviewed')->count();
        $acceptedCount = (clone $baseQuery)->where('status', 'accepted')->count();

        return view('applications.index', compact(
            'applications',
            'pendingCount',
            'reviewingCount',
            'interviewedCount',
            'acceptedCount'
        ));
    }

    /**
     * Show application details
     */
    public function show(Application $application)
    {
        // Check if current user has permission to view this application
        if (Auth::user()->isEmployer()) {
            // Employer can only view applications for their internships
            $hasAccess = $application->internship->employer_id == Auth::user()->employer->id;
        } else {
            // Regular users can only view their own applications
            $hasAccess = $application->user_id == Auth::id();
        }

        if (!$hasAccess) {
            abort(403, 'You do not have permission to view this application');
        }

        return view('applications.show', compact('application'));
    }

    /**
     * Update application status
     */
    public function updateStatus(Request $request, Application $application)
    {
        // Ensure only the employer who owns this internship can update status
        if (
            !Auth::user()->employer ||
            $application->internship->employer_id != Auth::user()->employer->id
        ) {
            abort(403, 'You do not have permission to update this application');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewing,interviewed,accepted,rejected',
        ]);

        $application->update([
            'status' => $validated['status']
        ]);

        return back()->with('success', 'Application status updated successfully.');
    }
    //updateNotes
    public function updateNotes(Request $request, Application $application)
    {
        // Ensure only the employer who owns this internship can update notes
        if (
            !Auth::user()->employer ||
            $application->internship->employer_id != Auth::user()->employer->id
        ) {
            abort(403, 'You do not have permission to update this application');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $application->update([
            'notes' => $validated['notes']
        ]);

        return back()->with('success', 'Application notes updated successfully.');
    }
}