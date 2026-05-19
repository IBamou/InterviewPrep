<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeneratedQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['concept_id', 'question', 'answer', 'rating', 'feedback', 'model_answer', 'set_number', 'tier'];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'set_number' => 'integer',
        ];
    }

    public function concept(): BelongsTo
    {
        return $this->belongsTo(Concept::class);
    }
}
