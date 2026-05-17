<?php

namespace App\Http\Requests;

use App\Models\Concept;
use App\Models\Domain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'domain_id' => ['required', 'exists:domains,id'],
            'concept_ids' => ['required', 'array', 'min:' . (config('quiz.domain.min_ready_concepts') ?? 3)],
            'concept_ids.*' => ['required', 'exists:concepts,id'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $domain = Domain::find($this->domain_id);
            if (!$domain || $domain->user_id !== Auth::id()) {
                $validator->errors()->add('domain_id', 'Invalid domain.');
                return;
            }

            foreach ($this->concept_ids as $id) {
                $concept = Concept::find($id);
                if (!$concept || $concept->domain_id !== $domain->id) {
                    $validator->errors()->add('concept_ids', 'One or more concepts do not belong to this domain.');
                    return;
                }
                if (!$concept->isQuizReady()) {
                    $validator->errors()->add('concept_ids', "Concept \"{$concept->title}\" is not ready for a quiz.");
                    return;
                }
            }
        });
    }
}
