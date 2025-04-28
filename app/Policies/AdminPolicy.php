<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can access admin features.
     */
    public function accessAdmin(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can manage other users.
     */
    public function manageUsers(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can promote others to admin.
     */
    public function promoteUsers(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can demote other admins.
     */
    public function demoteAdmins(User $user, User $targetUser): bool
    {
        // Prevent self-demotion or super admin demotion by non-super admins
        if ($user->id === $targetUser->id) {
            return false;
        }
        
        if ($targetUser->isSuperAdmin() && !$user->isSuperAdmin()) {
            return false;
        }
        
        return $user->isAdmin();
    }
}