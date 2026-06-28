<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserJob extends Model
{
    protected $table = 'user_jobs';

    protected $fillable = [
        'employer_id', 
        'title', 
        'description', 
        'requirements', 
        'salary_range', 
        'location', 
        'work_setting',
        'telecommuting',
        'has_questions',
        'fraud_score', 
        'is_fraud', 
        'is_visible', 
        'admin_override'
    ];  

    protected $casts = [
        'is_fraud' => 'boolean',
        'is_visible' => 'boolean',
        'admin_override' => 'boolean',
        'telecommuting' => 'boolean',
        'has_questions' => 'boolean',
        'fraud_score' => 'float',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }

    public function appeal(): HasOne 
    {
        return $this->hasOne(JobAppeal::class, 'job_id');
    }
}