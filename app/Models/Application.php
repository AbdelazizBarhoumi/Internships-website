<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'internship_id',
        'phone',
        'availability',
        'education',
        'institution',
        'field_of_study',
        'skills',
        'resume_path',
        'cover_letter',
        'transcript_path',
        'profile_photo_path',  // Add this line
        'why_interested',
        'status',
        'notes',
        'admin_notes',
        'interview_date',
        'response_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'availability' => 'date',
        'admin_notes' => 'string',
        'interview_date' => 'datetime',
        'response_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The possible education levels
     */
    const EDUCATION_LEVELS = [
        'high_school' => 'High School',
        'associate' => 'Associate Degree',
        'bachelor' => 'Bachelor\'s Degree',
        'master' => 'Master\'s Degree',
        'phd' => 'PhD'
    ];
    
    /**
     * The possible application statuses
     */
    const STATUSES = [
        'pending' => 'Pending Review',
        'reviewing' => 'Under Review',
        'interviewed' => 'Interviewed',
        'accepted' => 'Accepted',
        'rejected' => 'Rejected'
    ];

    /**
     * Get the user that owns the application.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the internship that the application is for.
     */
    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
    
    /**
     * Get the student profile if it exists
     */
    public function student()
    {
        return $this->hasOneThrough(
            Student::class, 
            User::class,
            'id', // Foreign key on users table
            'user_id', // Foreign key on students table
            'user_id', // Local key on applications table
            'id' // Local key on users table
        );
    }
    
    /**
     * Get resume URL
     */
    public function getResumeUrlAttribute()
    {
        return $this->resume_path ? Storage::url($this->resume_path) : null;
    }
    
    /**
     * Get transcript URL
     */
    public function getTranscriptUrlAttribute()
    {
        return $this->transcript_path ? Storage::url($this->transcript_path) : null;
    }
    
    /**
     * Get education level as readable text
     */
    public function getEducationLabelAttribute()
    {
        return self::EDUCATION_LEVELS[$this->education] ?? $this->education;
    }
    
    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
    
    /**
     * Get skills as array
     */
    public function getSkillsArrayAttribute()
    {
        if (empty($this->skills)) {
            return [];
        }
        
        return array_map('trim', explode(',', $this->skills));
    }
    
    /**
     * Get the status color for UI display
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'gray',
            'reviewing' => 'blue',
            'interviewed' => 'yellow',
            'accepted' => 'green',
            'rejected' => 'red'
        ];
        
        return $colors[$this->status] ?? 'gray';
    }
    
    /**
     * Get a truncated version of the cover letter
     */
    public function getTruncatedCoverLetterAttribute($length = 100)
    {
        return $this->cover_letter ? Str::limit($this->cover_letter, $length) : null;
    }
    
    /**
     * Get the days since application was submitted
     */
    public function getDaysSinceAppliedAttribute()
    {
        return $this->created_at->diffInDays(now());
    }
    
    /**
     * Check if application has been updated by the employer
     */
    public function getHasEmployerFeedbackAttribute()
    {
        return !empty($this->notes);
    }
    
    /**
     * Check if application has accompanying documents
     */
    public function getHasDocumentsAttribute()
    {
        return !empty($this->resume_path) || !empty($this->transcript_path);
    }
    
    /**
     * Format phone number for display
     */
    public function getFormattedPhoneAttribute()
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        
        if (strlen($phone) === 10) {
            return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6);
        }
        
        return $this->phone;
    }
    
    /**
     * Scope a query to only include applications with a certain status
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    
    /**
     * Scope a query to only include applications for active internships
     */
    public function scopeForActiveInternships($query)
    {
        return $query->whereHas('internship', function ($query) {
            $query->where('is_active', true);
        });
    }
    
    /**
     * Scope a query to only include applications from active users
     */
    public function scopeFromActiveUsers($query)
    {
        return $query->whereHas('user', function ($query) {
            $query->where('is_active', true);
        });
    }
    
    /**
     * Scope a query to include applications for a specific employer
     */
    public function scopeForEmployer($query, $employerId)
    {
        return $query->whereHas('internship', function ($query) use ($employerId) {
            $query->where('employer_id', $employerId);
        });
    }
    
    /**
     * Update the status of this application
     */
    public function updateStatus($status, $notes = null)
    {
        $this->status = $status;
        
        if ($status === 'interviewed') {
            $this->interview_date = now();
        } elseif (in_array($status, ['accepted', 'rejected'])) {
            $this->response_date = now();
        }
        
        if ($notes) {
            $this->notes = $notes;
        }
        
        return $this->save();
    }
}