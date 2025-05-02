<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        // Get search parameters
        $search = $request->input('search', '');
        $filter = $request->input('filter');
        $sort = $request->input('sort', 'newest');
        $location = $request->input('location');
        $duration = $request->input('duration');
        $paid = $request->input('paid');
        
        // Start building the query
        $query = Internship::with(['employer', 'tags']);
        
        // Apply search term filter if provided
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('location', 'LIKE', "%{$search}%")
                    ->orWhere('salary', 'LIKE', "%{$search}%")
                    ->orWhere('schedule', 'LIKE', "%{$search}%")
                    ->orWhereHas('tags', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('employer', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                          ->orWhere('email', 'LIKE', "%{$search}%");
                    });
            });
        }
        
        // Apply tag filter if provided
        if ($filter) {
            $query->whereHas('tags', function($q) use ($filter) {
                $q->where('name', $filter);
            });
        }
        
        // Apply location filter if provided
        if ($location && $location !== 'any') {
            if ($location === 'remote') {
                $query->where('location', 'LIKE', '%remote%');
            } else if ($location === 'hybrid') {
                $query->where('location', 'LIKE', '%hybrid%');
            } else if ($location === 'onsite') {
                $query->where(function($q) {
                    $q->where('location', 'NOT LIKE', '%remote%')
                      ->where('location', 'NOT LIKE', '%hybrid%');
                });
            }
        }
        
        // Apply compensation filter if provided
        if ($paid) {
            if ($paid === 'paid') {
                $query->where('is_paid', true);
            } else if ($paid === 'unpaid') {
                $query->where('is_paid', false);
            } else if ($paid === 'stipend') {
                $query->whereNotNull('salary');
            }
        }
        
        // Apply sorting
        switch ($sort) {
            case 'relevant':
                // For relevance sorting, we could implement a more complex algorithm
                // For now, let's default to sorting by id
                $query->orderBy('id', 'desc');
                break;
                
            case 'expiring':
                $query->whereNotNull('deadline')
                      ->where('deadline', '>=', now())
                      ->orderBy('deadline', 'asc');
                break;
                
            case 'company':
                $query->join('employers', 'internships.employer_id', '=', 'employers.id')
                      ->orderBy('employers.name', 'asc');
                break;
                
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        // Execute the query with pagination
        $internships = $query->paginate(10);
        
        
        // Determine if we're searching for a specific tag
        $searchedTag = $filter;
        
        // Return the view with all necessary data
        return view('results', [
            'internships' => $internships, 
            'search' => $search,
            'searchedTag' => $searchedTag
        ]);
    }
}