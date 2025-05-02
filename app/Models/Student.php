<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'education_level',
        'institution',
        'field_of_study',
        'graduation_date',
        'skills',
        'bio',
        'resume_path',
        'linkedin_url',
        'github_url',
        'portfolio_url',
        'profile_photo_path',
        'phone',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'graduation_date' => 'date',
    ];

    /**
     * Get the user that owns the student profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all applications submitted by this student.
     */
    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id', 'user_id');
    }
    
    /**
     * Get skills as array
     */
    public function getSkillsArrayAttribute()
    {
        if (!$this->skills) {
            return [];
        }
        
        return array_map('trim', explode(',', $this->skills));
    }
/**
 * Count all applications for this student
 * 
 * @return int
 */
public function countApplications()
{
    dd($this->applications());
    return $this->applications()->count();
}

/**
 * Count applications with a specific status
 * 
 * @param string $status The application status to count
 * @return int
 */
public function countApplicationsByStatus($status)
{
    return $this->applications()->where('status', $status)->count();
}

/**
 * Get pending applications count
 * 
 * @return int
 */
public function getPendingApplicationsCountAttribute()
{
    return $this->countApplicationsByStatus('pending');
}

/**
 * Get reviewing applications count
 * 
 * @return int
 */
public function getReviewingApplicationsCountAttribute()
{
    return $this->countApplicationsByStatus('reviewing');
}

/**
 * Get interviewed applications count
 * 
 * @return int
 */
public function getInterviewedApplicationsCountAttribute()
{
    return $this->countApplicationsByStatus('interviewed');
}

/**
 * Get accepted applications count
 * 
 * @return int
 */
public function getAcceptedApplicationsCountAttribute()
{
    return $this->countApplicationsByStatus('accepted');
}

/**
 * Get rejected applications count
 * 
 * @return int
 */
public function getRejectedApplicationsCountAttribute()
{
    return $this->countApplicationsByStatus('rejected');
}

}