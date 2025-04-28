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
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Internship::with(['employer', 'tags']);
        
        // Filter by employer if viewing own listings
        if ($request->has('employer') && Auth::check() && Auth::user()->isEmployer()) {
            $query->where('employer_id', Auth::user()->employer->id);
        }
        
        $internships = $query->orderBy('created_at', 'desc')
                            ->paginate(10)
                            ->groupBy('featured');
                            
        return view('internships.index', [
            'featuredInternships' => $internships[1] ?? collect(),
            'internships' => $internships[0] ?? collect(),
            'tags' => Tag::whereHas('internships')->get(),
        ]);
    }

    /**
     * Display a listing of the user's internships.
     */
    public function myInternships()
    {
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
            'url' => ['required', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'duration' => ['nullable', 'string', 'max:255'],
            'deadline' => ['nullable', 'date', 'after:today'],
            'positions' => ['nullable', 'integer', 'min:1'],
            'tags' => ['nullable', 'string', 'max:255'],
        ]);
        
        $attributes['featured'] = $request->has('featured');
        
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
        
        return redirect()->route('myinternship.show', $internship)
            ->with('success', 'Internship created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Internship $internship)
    {
        return view('internships.show', [
            'internship' => $internship->load(['employer', 'tags']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Internship $internship)
    {
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
        $this->authorize('update', $internship);
        
        $attributes = $request->validate([
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'salary' => ['required', 'string', 'max:255', 'min:3'],
            'schedule' => ['required', 'string', 'max:255', Rule::in(['Full-time', 'Part-time', 'Remote', 'Hybrid'])],
            'location' => ['required', 'string', 'max:255', 'min:5'],
            'url' => ['required', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'duration' => ['nullable', 'string', 'max:255'],
            'deadline' => ['nullable', 'date', 'after:today'],
            'positions' => ['nullable', 'integer', 'min:1'],
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
        
        return redirect()->route('myinternship.show', $internship)
            ->with('success', 'Internship updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Internship $internship)
    {
        $this->authorize('delete', $internship);
        
        $internship->delete();
        
        return redirect()->route('internships.mine')
            ->with('success', 'Internship deleted successfully!');
    }
}