<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    protected $fillable = [
        'job_id', 'seeker_id', 'cover_letter', 'status'
    ];

    public function userJob(): BelongsTo
    {
        return $this->belongsTo(UserJob::class, 'job_id');
    }

    public function seeker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seeker_id');
    }
    
}