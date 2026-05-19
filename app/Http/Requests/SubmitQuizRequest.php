<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'answers' => ['required', 'array'],
            'answers.*' => ['nullable', 'string', 'max:10000'],
            'ratings' => ['required', 'array'],
            'ratings.*' => ['required', 'integer', 'in:1,2,3,4,5'],
        ];
    }
}
