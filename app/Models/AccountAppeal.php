<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountAppeal extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'reason',
        'additional_info',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reviewed_at' => 'datetime',
    ];
    
    /**
     * Get the user who submitted this appeal.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the admin who reviewed this appeal.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}