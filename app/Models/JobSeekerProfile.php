<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobSeekerProfile extends Model
{
    protected $fillable = [
        'user_id', 'current_title', 'phone', 'availability', 
        'github_url', 'linkedin_url', 'summary', 'skills', 
        'experiences', 'education', 'cv_path'
    ];

    protected $casts = [
        'skills' => 'array',
        'experiences' => 'array',
        'education' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}