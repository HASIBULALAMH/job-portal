<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobPosting extends Model
{
    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'location',
        'salary',
        'job_type',
        'experience_level',
        'status',
        'deadline',
        'requirements',
        'responsibilities',
        'benefits',
    ];

    protected $casts = [
        'deadline' => 'date',
        'salary' => 'decimal:2',
    ];

    /**
     * Get the employer that owns the job posting.
     */
    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    /**
     * Scope a query to only include published job postings.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include active job postings.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'published')
                    ->where(function($q) {
                        $q->whereNull('deadline')
                          ->orWhere('deadline', '>=', now()->toDateString());
                    });
    }
}
