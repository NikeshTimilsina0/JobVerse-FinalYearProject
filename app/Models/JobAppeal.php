<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobAppeal extends Model
{
    protected $fillable = [
        'job_id', 'employer_id', 'appeal_reason', 'status', 'admin_notes'
    ];

    public function userJob(): BelongsTo
    {
        return $this->belongsTo(UserJob::class, 'job_id');
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
}