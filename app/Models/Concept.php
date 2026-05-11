<?php

namespace App\Models;

use App\Enums\Difficulty;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Casts\AsEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concept extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['domain_id', 'title', 'explanation', 'difficulty', 'status'];

    protected $casts = [
        'difficulty' => AsEnum::class.':'.Difficulty::class,
        'status' => AsEnum::class.':'.Status::class,
    ];

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function generatedQuestions(): HasMany
    {
        return $this->hasMany(GeneratedQuestion::class);
    }
}