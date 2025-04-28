<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    /** @use HasFactory<\Database\Factories\EmployerFactory> */
    use HasFactory;
    protected $fillable = [
        'employer_name',
        'employer_email',
        'employer_logo'
    ];
    
    public function internships()
    {
        return $this->hasMany(Internship::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
}
}