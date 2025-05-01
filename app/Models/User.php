<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'profile_photo_path',
        'last_login_at',
        'suspension_reason',
        'suspension_date',
        'suspension_end_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'suspension_date' => 'datetime',
            'suspension_end_date' => 'datetime',
        ];
    }

    /**
     * Get the URL for the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return Storage::url($this->profile_photo_path);
        }
        
        // Generate initials-based default avatar or use Gravatar
        $name = $this->name ?? 'User';
        $initials = strtoupper(substr($name, 0, 1));
        if (strpos($name, ' ') !== false) {
            $parts = explode(' ', $name);
            $initials = strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1));
        }
        
        // Generate a color based on the user ID for consistent coloring
        $colors = ['1E40AF', '047857', 'B91C1C', '7E22CE', 'B45309', '0369A1'];
        $colorIndex = $this->id % count($colors);
        $bgColor = $colors[$colorIndex];
        
        return "https://ui-avatars.com/api/?name={$initials}&color=ffffff&background={$bgColor}&size=150";
    }
    
    /**
     * Get the employer record associated with the user.
     */
    public function employer()
    {
        return $this->hasOne(Employer::class);
    }

    /**
     * Check if user is an employer
     * 
     * @return bool
     */
    public function isEmployer(): bool
    {
        return $this->employer()->exists();
    }
    
    /**
     * Get the student record associated with the user.
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }
    
    /**
     * Check if user is a student (has a student profile)
     * 
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->student()->exists();
    }
    
    /**
     * Get all applications submitted by the user.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Check if user has already applied for a specific internship.
     * 
     * @param Internship $internship
     * @return bool
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
     * Get all applications under review.
     */
    public function reviewingApplications()
    {
        return $this->applications()->where('status', 'reviewing');
    }

    /**
     * Get all interviewed applications.
     */
    public function interviewedApplications()
    {
        return $this->applications()->where('status', 'interviewed');
    }

    /**
     * Get all accepted applications.
     */
    public function acceptedApplications()
    {
        return $this->applications()->where('status', 'accepted');
    }

    /**
     * Get all rejected applications.
     */
    public function rejectedApplications()
    {
        return $this->applications()->where('status', 'rejected');
    }
    
    /**
     * Get all recent applications (last 30 days)
     */
    public function recentApplications()
    {
        return $this->applications()
            ->where('created_at', '>=', now()->subDays(30));
    }

    /**
     * Get the admin record associated with the user.
     */
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * Check if user is an admin
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->admin()->exists();
    }

    /**
     * Check if user is a super admin
     * 
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->admin && $this->admin->role === 'super_admin';
    }
    
    /**
     * Get user role as a string
     * 
     * @return string
     */
    public function getRoleAttribute(): string
    {
        if ($this->isAdmin()) {
            return $this->isSuperAdmin() ? 'super_admin' : 'admin';
        }
        
        if ($this->isEmployer()) {
            return 'employer';
        }
        
        if ($this->isStudent()) {
            return 'student';
        }
        
        return 'user';
    }
    
    /**
     * Get formatted display role
     */
    public function getFormattedRoleAttribute(): string
    {
        $roles = [
            'super_admin' => 'Super Administrator',
            'admin' => 'Administrator',
            'employer' => 'Employer',
            'student' => 'Student',
            'user' => 'User'
        ];
        
        return $roles[$this->role] ?? 'User';
    }
    
    /**
     * Get applications count for this user
     */
    public function getApplicationsCountAttribute(): int
    {
        return $this->applications()->count();
    }
    
    /**
     * Check if user account is suspended
     */
    public function getIsSuspendedAttribute(): bool
    {
        return !$this->is_active;
    }
    
    /**
     * Check if user has automatic suspension end date
     */
    public function getHasTemporarySuspensionAttribute(): bool
    {
        return $this->is_suspended && $this->suspension_end_date !== null;
    }
    
    /**
     * Get days remaining in suspension
     */
    public function getDaysRemainingInSuspensionAttribute(): ?int
    {
        if (!$this->has_temporary_suspension) {
            return null;
        }
        
        return now()->diffInDays($this->suspension_end_date, false);
    }
    
    /**
     * Suspend the user account
     * 
     * @param string|null $reason Reason for suspension
     * @param \DateTime|null $endDate End date for temporary suspension
     * @return bool
     */
    public function suspend(?string $reason = null, ?\DateTime $endDate = null): bool
    {
        $this->is_active = false;
        $this->suspension_reason = $reason;
        $this->suspension_date = now();
        $this->suspension_end_date = $endDate;
        
        return $this->save();
    }
    
    /**
     * Reactivate a suspended account
     * 
     * @return bool
     */
    public function reactivate(): bool
    {
        $this->is_active = true;
        $this->suspension_reason = null;
        $this->suspension_date = null;
        $this->suspension_end_date = null;
        
        return $this->save();
    }
    
    /**
     * Log user login time
     * 
     * @return bool
     */
    public function logLogin(): bool
    {
        $this->last_login_at = now();
        return $this->save();
    }
    
    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope a query to only include suspended users.
     */
    public function scopeSuspended($query)
    {
        return $query->where('is_active', false);
    }
    
    /**
     * Scope a query to only include employers.
     */
    public function scopeEmployers($query)
    {
        return $query->whereHas('employer');
    }
    
    /**
     * Scope a query to only include students.
     */
    public function scopeStudents($query)
    {
        return $query->whereHas('student');
    }
    
    /**
     * Scope a query to only include admins.
     */
    public function scopeAdmins($query)
    {
        return $query->whereHas('admin');
    }
    
    /**
     * Scope a query to only include users with newsletter subscriptions.
     */
    public function scopeSubscribedToNewsletter($query)
    {
        return $query->where('newsletter_subscribed', true);
    }
    
    /**
     * Get users with recent activity
     */
    public function scopeRecentlyActive($query, $days = 30)
    {
        return $query->where('last_login_at', '>=', now()->subDays($days));
    }
}