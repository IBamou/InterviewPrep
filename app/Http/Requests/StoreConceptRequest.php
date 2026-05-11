<?php

namespace App\Http\Requests;

use App\Enums\Difficulty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreConceptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'explanation' => ['required', 'string'],
            'difficulty' => ['required', Rule::enum(Difficulty::class)],
        ];
    }
}