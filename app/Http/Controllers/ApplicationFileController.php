<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicationFileController extends Controller
{
    /**
     * Force download application documents
     */
    public function download(Request $request, Application $application, string $type)
    {
        // Check if employer owns this application's internship
        if (Auth::user()->employer->id !== $application->internship->employer_id) {
            abort(403, 'Unauthorized access to application documents');
        }
        
        // Determine which file to download
        $filePath = null;
        $fileName = null;
        
        if ($type === 'resume' && $application->resume_path) {
            $filePath = $application->resume_path;
            $fileName = "resume-{$application->id}-{$application->user->name}.pdf";
        } elseif ($type === 'transcript' && $application->transcript_path) {
            $filePath = $application->transcript_path;
            $fileName = "transcript-{$application->id}-{$application->user->name}.pdf";
        } else {
            abort(404, 'File not found');
        }
        
        // Get file extension from storage
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        if ($extension) {
            $fileName = str_replace('.pdf', ".$extension", $fileName);
        }
        
        // Force download the file
        return Storage::download($filePath, $fileName);
    }
}