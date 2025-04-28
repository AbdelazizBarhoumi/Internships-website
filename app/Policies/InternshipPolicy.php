<?php

namespace App\Policies;

use App\Models\Internship;
use App\Models\User;


class InternshipPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    
    public function update(User $user, Internship $internship): bool
   {
     return $internship->employer->user->is($user);
   }
   public function delete(User $user, Internship $internship): bool
   {
    return ($internship->employer->user->is($user) && $internship->employer->is_admin) ?? false;
   }

   public function view(User $user, Internship $internship): bool
   {
       return $internship->employer->user->is($user) || $internship->is_public;
   }

}
