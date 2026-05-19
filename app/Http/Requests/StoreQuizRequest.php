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
            'concept_ids' => ['required', 'array', 'min:' . max(config('quiz.domain.min_ready_concepts') ?? 3, 1)],
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

            $quota = config('quiz.quota.per_domain_per_day');
            $recentCount = Auth::user()->quizzes()
                ->where('domain_id', $domain->id)
                ->where('created_at', '>=', now()->subHours(24))
                ->count();

            if ($recentCount >= $quota) {
                $validator->errors()->add('domain_id', "Quiz limit reached for this domain (max {$quota} per 24 hours).");
                return;
            }

            $concepts = Concept::whereIn('id', $this->concept_ids)->get();

            if ($concepts->count() !== count($this->concept_ids)) {
                $validator->errors()->add('concept_ids', 'One or more concepts do not exist.');
                return;
            }

            foreach ($concepts as $concept) {
                if ($concept->domain_id !== $domain->id) {
                    $validator->errors()->add('concept_ids', "Concept \"{$concept->title}\" does not belong to this domain.");
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
