<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function employer()
    {
        return $this->hasOne(Employer::class);
    }
    public function isEmployer(): bool
    {
        return $this->employer()->exists();
    }
    // app/Models/User.php
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
    /**
     * Check if user has already applied for a specific internship.
     */
    public function hasAppliedTo(Internship $internship): bool
    {
        return $this->applications()
            ->where('internship_id', $internship->id)
            ->exists();
    }

    /**
     * Get all pending applications.
     */
    public function pendingApplications()
    {
        return $this->applications()->where('status', 'pending');
    }

    /**
     * Get all accepted applications.
     */
    public function acceptedApplications()
    {
        return $this->applications()->where('status', 'accepted');
    }
    // ...existing code...

    /**
     * Get the admin record associated with the user.
     */
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin()
    {
        return $this->admin()->exists();
    }

    /**
     * Check if user is a super admin
     */
    public function isSuperAdmin()
    {
        return $this->admin && $this->admin->role === 'super_admin';
    }
}
;