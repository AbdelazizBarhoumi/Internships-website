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
        // Find the tag by ID
        $tag = Tag::findOrFail($tagName);

        $internships = $tag->internships()
            ->whereHas('employer.user', function ($query) {
                $query->where('is_active', true);
            })
            ->paginate(20);

        return view('results', [
            'internships' => $internships,
            'search' => $tag->name,
            'searchedTag' => $tag
        ]);
    }
}
