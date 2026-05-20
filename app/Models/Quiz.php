<?php

namespace App\Models;

use App\Enums\QuizStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'domain_id', 'time_limit_minutes', 'started_at', 'submitted_at', 'status', 'total_score', 'max_score', 'passed', 'generating'];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
            'status' => QuizStatus::class,
            'passed' => 'boolean',
            'generating' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }
}
