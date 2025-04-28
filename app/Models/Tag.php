<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;
    protected $fillable = ['name'];
    public function internships()
    {
        return $this->belongsToMany(Internship::class, 'internship_tag', 'tag_id', 'internship_id');
    }

}
