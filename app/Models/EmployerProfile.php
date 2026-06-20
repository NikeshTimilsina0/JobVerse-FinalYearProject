<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmployerProfile extends Model
{
    protected $fillable = [
        'user_id', 'company_name', 'company_logo', 'website_url', 
        'industry', 'company_size', 'about', 'address', 'phone'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(UserJob::class, 'employer_id', 'user_id');
    }
}