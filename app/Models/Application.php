<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Application extends Model
{
    use HasFactory;
    
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
        'skills',
        'resume_path',
        'cover_letter',
        'transcript_path',
        'why_interested',
        'status',
        'notes',
        'admin_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'availability' => 'date',
        'admin_notes' => 'string',
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
        $labels = [
            'high_school' => 'High School',
            'associate' => 'Associate Degree',
            'bachelor' => 'Bachelor\'s Degree',
            'master' => 'Master\'s Degree',
            'phd' => 'PhD'
        ];
        
        return $labels[$this->education] ?? $this->education;
    }
    
    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Pending Review',
            'reviewing' => 'Under Review',
            'interviewed' => 'Interviewed',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected'
        ];
        
        return $labels[$this->status] ?? $this->status;
    }
}