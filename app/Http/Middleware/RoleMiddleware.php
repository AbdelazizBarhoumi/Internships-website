<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }
        
        if ($role === 'applicant' && !$request->user()->isApplicant()) {
            abort(403, 'Access denied: Requires applicant role');
        }
        
        if ($role === 'employer' && !$request->user()->isEmployer()) {
            abort(403, 'Access denied: Requires employer role');
        }
        
        if ($role === 'admin' && !$request->user()->isAdmin()) {
            abort(403, 'Access denied: Requires admin privileges');
        }
        
        return $next($request);
    }
}