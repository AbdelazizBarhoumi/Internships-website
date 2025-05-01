<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display the student's profile
     */
    public function show()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            return redirect()->route('student.create')
                ->with('info', 'Please complete your student profile first.');
        }
        
        return view('students.show', compact('student'));
    }
    
    /**
     * Show the form for creating a new student profile
     */
    public function create()
    {
        // Check if user already has a student profile
        if (Auth::user()->student) {
            return redirect()->route('student.edit')
                ->with('info', 'You already have a student profile.');
        }
        
        return view('students.create');
    }
    
    /**
     * Store a newly created student profile
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'education_level' => 'required|in:high_school,associate,bachelor,master,phd',
            'institution' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'graduation_date' => 'nullable|date',
            'skills' => 'nullable|string',
            'bio' => 'nullable|string|max:1000',
            'resume' => 'nullable|file|mimes:pdf|max:2048',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
        ]);
        
        // Handle resume upload
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $validated['resume_path'] = $resumePath;
        }


        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
            $validated['profile_photo_path'] = $profilePhotoPath;
        }
        
        // Create the student profile
        $student = new Student($validated);
        $student->user_id = Auth::id();
        $student->save();
        
        return redirect()->route('dashboard')
            ->with('success', 'Student profile created successfully!');
    }
    
    /**
     * Show the form for editing the student profile
     */
    public function edit()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            return redirect()->route('student.create')
                ->with('info', 'Please create your student profile first.');
        }
        
        return view('students.edit', compact('student'));
    }
    
    /**
     * Update the student profile
     */
    public function update(Request $request)
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            return redirect()->route('student.create')
                ->with('info', 'Please create your student profile first.');
        }
        
        $validated = $request->validate([
            'education_level' => 'required|in:high_school,associate,bachelor,master,phd',
            'institution' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'graduation_date' => 'nullable|date',
            'skills' => 'nullable|string',
            'bio' => 'nullable|string|max:1000',
            'resume' => 'nullable|file|mimes:pdf|max:2048',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
        ]);
        
        // Handle resume upload
        if ($request->hasFile('resume')) {
            // Delete old resume if it exists
            if ($student->resume_path) {
                Storage::disk('public')->delete($student->resume_path);
            }
            
            $resumePath = $request->file('resume')->store('resumes', 'public');
            $validated['resume_path'] = $resumePath;
        }


        if ($request->hasFile('profile_photo')) {

            if ($student->profile_photo_path) {
                Storage::disk('public')->delete($student->profile_photo_path);
            }
            
            $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
            $validated['profile_photo_path'] = $profilePhotoPath;
        }
        
        // Update the student profile
        $student->update($validated);
        
        return redirect()->route('student.show')
            ->with('success', 'Student profile updated successfully!');
    }
}