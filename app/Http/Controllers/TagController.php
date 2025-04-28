<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Show internships for a specific tag with case-insensitive lookup
     */
    public function __invoke(Request $request, $tagName)
    {
        // Find the tag case-insensitively
        $tag = Tag::whereRaw('LOWER(name) = ?', [strtolower($tagName)])->firstOrFail();
        
        $internships = $tag->internships()->paginate(20);
        
        return view('results', [
            'internships' => $internships,
            'search' => $tag->name,
            'searchedTag' => $tag // Pass the tag object
        ]);
    }
}
