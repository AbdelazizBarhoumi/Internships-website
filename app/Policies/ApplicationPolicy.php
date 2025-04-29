<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Helpers\Settings;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create an application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Internship  $internship
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Internship $internship)
    {
        // Check if user is active
        if (!$user->is_active) {
            return false;
        }

        // Check if user is an employer or admin (they shouldn't apply)
        if ($user->isEmployer() || $user->isAdmin()) {
            return false;
        }

        // Check if user has already applied
        if ($user->hasAppliedTo($internship)) {
            return false;
        }

        // Check if internship deadline has passed
        if ($internship->deadline_date && $internship->deadline_date->isPast()) {
            return false;
        }

        // Check if internship is active
        if (!$internship->is_active) {
            return false;
        }

        // Check if employer is active
        if (!$internship->employer->user->is_active) {
            return false;
        }

        // Check if user has reached max applications limit
        $maxApplications = Settings::get('max_applications_per_user', 0);
        if ($maxApplications > 0) {
            $currentApplicationsCount = $user->applications()->count();
            if ($currentApplicationsCount >= $maxApplications) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine whether the user can view their application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Application $application)
    {
        // User can view their own application
        if ($user->id === $application->user_id) {
            return true;
        }

        // Employer can view applications to their internships
        if ($user->isEmployer()) {
            return $user->employer->id === $application->internship->employer_id;
        }

        // Admins can view all applications
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can withdraw an application.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function withdraw(User $user, Application $application)
    {
        // Only the user who created the application can withdraw it
        // And only if it's still pending
        return $user->id === $application->user_id && 
               $application->status === 'pending';
    }
}