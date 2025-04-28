<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'role',
        'permissions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'permissions' => 'json',
    ];

    /**
     * Get the user that owns the admin record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if admin has super admin role
     */
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }
}