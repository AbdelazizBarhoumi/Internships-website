<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

   protected $fillable = [
       'title',
       'salary',
       'location',
       'schedule',
       'url',
       'featured',
       'description',    // Add this field
       'duration',       // Add this field
       'deadline',       // Add this field
       'positions'       // Add this field
   ];

   /**
    * The attributes that should be cast.
    *
    * @var array<string, string>
    */
   protected $casts = [
       'featured' => 'boolean',
       'deadline' => 'date',
       'positions' => 'integer'
   ];

    /**
     * Get the employer that owns the internship.
     */
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    /**
     * Get all applications for this internship.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Add a tag to the internship.
     *
     * @param string $tagName
     * @return $this
     */
    public function tag(string $tagName)
    {
        $tag = Tag::firstOrCreate(['name' => $tagName]);
        $this->tags()->attach($tag);
        return $this;
    }

    /**
     * Get all tags associated with the internship.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get random tags for this internship.
     *
     * @param int $count
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function randomTags($count = 4)
    {
        return $this->tags->count() <= $count 
            ? $this->tags 
            : $this->tags->random($count);
    }

    /**
     * Get random tags except the specified one.
     *
     * @param int $excludeId
     * @param int $count
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function randomTagsExcept($excludeId, $count = 3)
    {
        $filteredTags = $this->tags->where('id', '!=', $excludeId);
        return $filteredTags->count() <= $count 
            ? $filteredTags 
            : $filteredTags->random(min($count, $filteredTags->count()));
    }

    /**
     * Get pending applications count.
     *
     * @return int
     */
    public function pendingApplicationsCount()
    {
        return $this->applications()->where('status', 'pending')->count();
    }

    /**
     * Get accepted applications count.
     *
     * @return int
     */
    public function acceptedApplicationsCount()
    {
        return $this->applications()->where('status', 'accepted')->count();
    }

    /**
     * Check if the user has already applied to this internship.
     *
     * @param User $user
     * @return bool
     */
    public function hasApplicant(User $user)
    {
        return $this->applications()->where('user_id', $user->id)->exists();
    }

    /**
     * Scope a query to only include featured internships.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
    public function isExpired()
{
    return $this->deadline && $this->deadline->isPast();
}

// Add this method for displaying positions status
public function getAvailablePositionsCount()
{
    $filled = $this->applications()->where('status', 'accepted')->count();
    return $this->positions ? ($this->positions - $filled) : null;
}

// Add this accessor for formatted deadline
public function getDeadlineFormattedAttribute()
{
    return $this->deadline ? $this->deadline->format('M d, Y') : 'No deadline';
}
}