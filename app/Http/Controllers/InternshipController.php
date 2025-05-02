<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;

use Illuminate\Routing\Controller;

class InternshipController extends Controller
{
    use AuthorizesRequests;

    /**
     * Constructor - apply middleware
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        // Remove the active.user middleware since we'll handle it directly
    }
    
    /**
     * Check if the current user is active
     * Returns true if active, redirects if not
     */
    protected function checkUserIsActive()
    {
        if (Auth::check() && !Auth::user()->is_active) {
            return false;
        }
        
        return true;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $baseQuery = Internship::with(['employer', 'tags'])
            // Only show internships from active users
            ->whereHas('employer.user', function($query) {
                $query->where('is_active', true);
            })
            // Only show active internships
            ->where('is_active', true);
        
        // Filter by employer if viewing own listings
        if ($request->has('employer') && Auth::check() && Auth::user()->isEmployer()) {
            $baseQuery->where('employer_id', Auth::user()->employer->id);
        }
        
        // Get featured internships with pagination
        $featuredInternships = (clone $baseQuery)
            ->where('featured', true)
            ->orderBy('created_at', 'desc')
            ->paginate(6, ['*'], 'featured_page'); // Use 'featured_page' as the page parameter
            
        // Get regular internships with pagination (use a different page parameter)
        $regularInternships = $baseQuery
            ->where('featured', false)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page'); // Use default 'page' parameter
                            
        return view('internships.index', [
            'featuredInternships' => $featuredInternships,
            'internships' => $regularInternships,
            'tags' => Tag::whereHas('internships', function($query) {
                $query->whereHas('employer.user', function($subQuery) {
                    $subQuery->where('is_active', true);
                })->where('is_active', true);
            })->get(),        
        ]);
    }

    /**
     * Display a listing of the user's internships.
     */
    public function myInternships()
    {
        // Check if user is active
        if (Auth::check() && !Auth::user()->is_active) {
        return redirect()->route('account.suspended')
                ->with('error', 'Your account is currently suspended. Please contact an administrator.');
        }
        
        // Check if user has an employer profile
        if (!Auth::user()->isEmployer()) {
            return redirect()->route('home')
                ->with('error', 'You need an employer profile to manage internships.');
        }
        
        $internships = Auth::user()->employer->internships()
            ->with(['tags'])
            ->withCount(['applications', 'applications as pending_count' => function($query) {
                $query->where('status', 'pending');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('internships.mine', [
            'internships' => $internships,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if user is active
        if (Auth::check() && !Auth::user()->is_active) {
        return redirect()->route('account.suspended')
                ->with('error', 'Your account is currently suspended. You cannot create internships.');
        }
        
        // Check if user has an employer profile
        if (!Auth::user()->isEmployer()) {
            return redirect()->route('employer.create')
                ->with('error', 'You need to create an employer profile first.');
        }
        
        return view('internships.create', [
            'popularTags' => Tag::withCount('internships')
                ->orderBy('internships_count', 'desc')
                ->take(10)
                ->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if user is active
        if (Auth::check() && !Auth::user()->is_active) {
        return redirect()->route('account.suspended')
                ->with('error', 'Your account is currently suspended. You cannot post internships.');
        }
        
        // Check if user has an employer profile
        if (!Auth::user()->isEmployer()) {
            return redirect()->route('employer.create')
                ->with('error', 'You need to create an employer profile first.');
        }
        
        $attributes = $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'salary' => ['required', 'string', 'max:255', 'min:3'],
            'schedule' => ['required', 'string', 'max:255', Rule::in(['Full-time', 'Part-time', 'Remote', 'Hybrid'])],
            'location' => ['required', 'string', 'max:255', 'min:5'],
            'description' => ['nullable', 'string', 'max:5000'],
            'duration' => ['nullable', 'string', 'max:255'],
            'deadline_date' => ['nullable', 'date', 'after:today'],
            'tags' => ['nullable', 'string', 'max:255'],
        ]);
        
        $attributes['featured'] = $request->has('featured');
        // Set is_active status based on settings or default to true
        $attributes['is_active'] = true;
        
        $internship = Auth::user()->employer->internships()->create(
            Arr::except($attributes, ['tags'])
        );
        
        // Handle tags
        if (!empty($attributes['tags'])) {
            foreach (explode(',', $attributes['tags']) as $tagName) {
                if (trim($tagName)) {
                    $internship->tag(trim($tagName));
                }
            }
        }
        
        return redirect()->route('internship.show', $internship)
            ->with('success', 'Internship created successfully!');
    }

    /**
     * Display the specified internship.
     *
     * @param  \App\Models\Internship  $internship
     * @return \Illuminate\Http\Response
     */
    public function show(Internship $internship)
    {
        // Only increment the view count if:
        // 1. The viewer is not the owner of the internship
        // 2. We're not in an admin context
        
        if (auth()->guest() || auth()->id() !== $internship->employer_id) {
            // You could use a session to prevent multiple views in same session
            $viewedInternships = session()->get('viewed_internships', []);
            
            if (!in_array($internship->id, $viewedInternships)) {
                $internship->incrementViewCount();
                
                // Add this internship to the viewed list
                $viewedInternships[] = $internship->id;
                session()->put('viewed_internships', $viewedInternships);
            }
        }
        
        // Ensure inactive users' internships are not visible unless to the owner or admin
        $isOwner = Auth::check() && Auth::user()->isEmployer() && 
                  Auth::user()->employer->id === $internship->employer_id;
        $isAdmin = Auth::check() && Auth::user()->isAdmin();
        
        if (!$internship->is_active && !$isOwner && !$isAdmin) {
            abort(404, 'Internship not found');
        }
        
        // If employer account is suspended, only show to the owner or admin
        if (!$internship->employer->user->is_active && !$isOwner && !$isAdmin) {
            abort(404, 'Internship not found');
        }
        
        return view('internships.show', [
            'internship' => $internship->load(['employer', 'tags']),
            'isOwner' => $isOwner,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Internship $internship)
    {
        // Check if user is active
        if (Auth::check() && !Auth::user()->is_active) {
        return redirect()->route('account.suspended')
                ->with('error', 'Your account is currently suspended. You cannot edit internships.');
        }
        
        $this->authorize('update', $internship);
        
        return view('internships.edit', [
            'internship' => $internship,
            'popularTags' => Tag::withCount('internships')
                ->orderBy('internships_count', 'desc')
                ->take(10)
                ->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Internship $internship)
    {
        // Check if user is active
        if (Auth::check() && !Auth::user()->is_active) {
        return redirect()->route('account.suspended')
                ->with('error', 'Your account is currently suspended. You cannot update internships.');
        }
        
        $this->authorize('update', $internship);
        
        $attributes = $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'salary' => ['required', 'string', 'max:255', 'min:3'],
            'schedule' => ['required', 'string', 'max:255', Rule::in(['Full-time', 'Part-time', 'Remote', 'Hybrid'])],
            'location' => ['required', 'string', 'max:255', 'min:5'],
            'description' => ['nullable', 'string', 'max:5000'],
            'duration' => ['nullable', 'string', 'max:255'],
            'deadline_date' => ['nullable', 'date', 'after:today'],
            'tags' => ['nullable', 'string', 'max:255'],
        ]);
        
        $attributes['featured'] = $request->has('featured');
        
        // Update the specific internship
        $internship->update(Arr::except($attributes, ['tags']));
        
        // Handle tags
        if (isset($attributes['tags'])) {
            // Clear existing tags first
            $internship->tags()->detach();
            
            // Add new tags
            foreach (explode(',', $attributes['tags']) as $tagName) {
                if (trim($tagName)) {
                    $internship->tag(trim($tagName));
                }
            }
        }
        
        return redirect()->route('internship.show', $internship)
            ->with('success', 'Internship updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Internship $internship)
    {
        // Check if user is active
        if (Auth::check() && !Auth::user()->is_active) {
        return redirect()->route('account.suspended')
                ->with('error', 'Your account is currently suspended. You cannot delete internships.');
        }
        
        $this->authorize('delete', $internship);
        
        $internship->delete();
        
        return redirect()->route('internships.mine')
            ->with('success', 'Internship deleted successfully!');
    }
}