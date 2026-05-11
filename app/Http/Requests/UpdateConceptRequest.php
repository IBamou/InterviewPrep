<?php

namespace App\Http\Requests;

use App\Enums\Difficulty;
use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateConceptRequest extends FormRequest
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
            'status' => ['required', Rule::enum(Status::class)],
        ];
    }
}