<?php

namespace App\Services;

use App\Models\Concept;
use App\Models\Domain;

class PromptBuilder
{
    protected int $dedupQuestionCount = 15;

    protected function buildGenerateQuestionsSystemPrompt(): string
    {
        return <<<'PROMPT'
You are a technical interview coach. First, check if the following concept is relevant to its parent domain. If it is NOT relevant, return: {"error": "unrelated", "message": "The concept is not related to the domain."}

If it IS relevant, generate exactly 5 mock interview questions.

Return ONLY a valid JSON object. Either:
{"error": "unrelated", "message": "..."}
OR
{"questions": ["Question 1?", "Question 2?", "Question 3?", "Question 4?", "Question 5?"]}
PROMPT;
    }

    protected function buildGenerateQuestionsUserPrompt(Concept $concept): string
    {
        $domainContext = $concept->domain ? "Domain: {$concept->domain->name}" : '';
        $domainDescription = ($concept->domain && $concept->domain->description) ? "\nDomain Description: {$concept->domain->description}" : '';

        $dedupSection = $this->buildDedupSection($concept);

        return <<<PROMPT
{$domainContext}{$domainDescription}
Concept: {$concept->title}
Difficulty Level: {$concept->difficulty->value}
Explanation:
{$concept->explanation}

Generate 5 interview questions that test understanding of this concept at the {$concept->difficulty->value} level, specifically within the context of the domain mentioned above.
{$dedupSection}
PROMPT;
    }

    public function buildGenerateQuestionsMessages(Concept $concept): array
    {
        return [
            ['role' => 'system', 'content' => $this->buildGenerateQuestionsSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildGenerateQuestionsUserPrompt($concept)],
        ];
    }

    protected function buildEvaluateAnswersSystemPrompt(): string
    {
        return <<<'PROMPT'
You are an interview coach evaluating candidate answers for a technical concept.

For each question-answer pair below, provide:
1. A rating from 1 to 5 (integer)
2. Brief constructive feedback
3. A model answer that would score 5/5

Return ONLY valid JSON with this exact structure:
{"evaluations": [{"question_index": 0, "rating": 4, "feedback": "...", "model_answer": "..."}, ...]}
PROMPT;
    }

    protected function buildEvaluateAnswersUserPrompt(Concept $concept, array $answers): string
    {
        $questionsList = '';
        foreach ($answers as $i => $qa) {
            $n = $i + 1;
            $questionsList .= "Q{$n}: {$qa['question']}\nA{$n}: {$qa['answer']}\n\n";
        }

        $domainContext = $concept->domain ? "Domain: {$concept->domain->name}\n" : '';
        $domainDescription = ($concept->domain && $concept->domain->description) ? "Domain Description: {$concept->domain->description}\n" : '';

        return <<<PROMPT
{$domainContext}{$domainDescription}Concept: {$concept->title}
Difficulty: {$concept->difficulty->value}

{$questionsList}
PROMPT;
    }

    public function buildEvaluateAnswersMessages(Concept $concept, array $answers): array
    {
        return [
            ['role' => 'system', 'content' => $this->buildEvaluateAnswersSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildEvaluateAnswersUserPrompt($concept, $answers)],
        ];
    }

    protected function buildDedupSection(Concept $concept): string
    {
        $existingQuestions = $concept->generatedQuestions()
            ->orderBy('id', 'desc')
            ->limit($this->dedupQuestionCount)
            ->pluck('question')
            ->toArray();

        if (empty($existingQuestions)) {
            return '';
        }

        $list = implode("\n", array_map(fn ($q) => "- {$q}", $existingQuestions));

        return "\n\nPreviously generated questions for this concept — DO NOT repeat or rephrase these:\n{$list}\n";
    }

    protected function buildImproveDomainDescriptionSystemPrompt(): string
    {
        return <<<'PROMPT'
You are a technical education expert helping to improve domain descriptions for an interview preparation app.

Rewrite the given description to be a solid, concise definition (1-2 sentences max). Focus on what the domain is and its core purpose. Do not add fluff, history, or unnecessary details.

Return ONLY a valid JSON object:
{"improved_description": "Your improved text here"}
PROMPT;
    }

    protected function buildImproveDomainDescriptionUserPrompt(Domain $domain): string
    {
        $current = $domain->description ?: '(No description provided)';

        return <<<PROMPT
Domain: {$domain->name}
Current description:
{$current}

Rewrite this as a concise, solid definition (1-2 sentences max).
PROMPT;
    }

    public function buildImproveDomainDescriptionMessages(Domain $domain): array
    {
        return [
            ['role' => 'system', 'content' => $this->buildImproveDomainDescriptionSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildImproveDomainDescriptionUserPrompt($domain)],
        ];
    }

    protected function buildImproveConceptExplanationSystemPrompt(): string
    {
        return <<<'PROMPT'
You are a technical education expert helping to improve concept explanations for an interview preparation app.

Rewrite the given explanation to be a solid, concise definition (2-3 short sentences max). Cover what it is and why it matters for interviews. Do not add long examples, history, or unnecessary details. Keep it tight and focused.

Return ONLY a valid JSON object:
{"improved_explanation": "Your improved text here"}
PROMPT;
    }

    protected function buildImproveConceptExplanationUserPrompt(Concept $concept): string
    {
        $current = $concept->explanation ?: '(No explanation provided)';

        return <<<PROMPT
Concept: {$concept->title}
Difficulty: {$concept->difficulty->value}
Current explanation:
{$current}

Rewrite this as a concise, solid definition (2-3 short sentences max).
PROMPT;
    }

    public function buildImproveConceptExplanationMessages(Concept $concept): array
    {
        return [
            ['role' => 'system', 'content' => $this->buildImproveConceptExplanationSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildImproveConceptExplanationUserPrompt($concept)],
        ];
    }
}
