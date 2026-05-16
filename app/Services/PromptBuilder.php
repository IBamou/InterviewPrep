<?php

namespace App\Services;

use App\Models\Concept;
use App\Models\Domain;
use App\Models\User;

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

    protected function buildGenerateQuestionsUserPrompt(Concept $concept, ?User $user = null): string
    {
        $domainContext = $concept->domain ? "Domain: {$concept->domain->name}" : '';
        $domainDescription = ($concept->domain && $concept->domain->description) ? "\nDomain Description: {$concept->domain->description}" : '';

        $userContext = $this->buildUserContext($user);

        $dedupSection = $this->buildDedupSection($concept);

        return <<<PROMPT
{$userContext}{$domainContext}{$domainDescription}
Concept: {$concept->title}
Difficulty Level: {$concept->difficulty->value}
Explanation:
{$concept->explanation}

Generate 5 interview questions that test understanding of this concept at the {$concept->difficulty->value} level, specifically within the context of the domain mentioned above.
{$dedupSection}
PROMPT;
    }

    public function buildGenerateQuestionsMessages(Concept $concept, ?User $user = null): array
    {
        return [
            ['role' => 'system', 'content' => $this->buildGenerateQuestionsSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildGenerateQuestionsUserPrompt($concept, $user)],
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

    protected function buildUserContext(?User $user): string
    {
        if (!$user || !$user->specialization) {
            return '';
        }

        $parts = [];

        if ($user->status) {
            $parts[] = "User Status: {$user->status->label()}";
        }

        if ($user->specialization) {
            $parts[] = "Specialization: {$user->specialization->label()} Developer";
        }

        if ($user->experience_years) {
            $parts[] = "Experience: {$user->experience_years->label()}";
        }

        if ($user->tech_stack && is_array($user->tech_stack) && !empty($user->tech_stack)) {
            $techList = implode(', ', $user->tech_stack);
            $parts[] = "Tech Stack: {$techList}";
        }

        if ($user->interview_goal) {
            $parts[] = "Goal: {$user->interview_goal->label()}";
        }

        if (empty($parts)) {
            return '';
        }

        return "User Profile:\n" . implode("\n", $parts) . "\n\n";
    }

    protected function buildImproveDomainDescriptionSystemPrompt(): string
    {
        return <<<'PROMPT'
You are a technical education expert helping with domain descriptions for an interview preparation app.

If a description is provided, rewrite it to be a solid, concise definition (1-2 sentences max). Focus on what the domain is and its core purpose. Do not add fluff, history, or unnecessary details.
If no description is provided, generate one from scratch based on the domain name.

Return ONLY a valid JSON object:
{"improved_description": "Your improved text here"}
PROMPT;
    }

    protected function buildImproveDomainDescriptionUserPrompt(Domain $domain): string
    {
        $isEmpty = empty(trim($domain->description ?? ''));
        $current = $isEmpty ? '(No description provided — generate one from scratch)' : $domain->description;

        $instruction = $isEmpty
            ? "Generate a concise, solid definition (1-2 sentences max) for this domain based on its name."
            : "Rewrite this as a concise, solid definition (1-2 sentences max).";

        return <<<PROMPT
Domain: {$domain->name}
Current description:
{$current}

{$instruction}
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
You are a technical education expert helping with concept explanations for an interview preparation app.

If an explanation is provided, rewrite it to be a solid, concise definition (2-3 short sentences max). Cover what it is and why it matters for interviews. Do not add long examples, history, or unnecessary details. Keep it tight and focused.
If no explanation is provided, generate one from scratch based on the concept title and difficulty level.

Return ONLY a valid JSON object:
{"improved_explanation": "Your improved text here"}
PROMPT;
    }

    protected function buildImproveConceptExplanationUserPrompt(Concept $concept): string
    {
        $isEmpty = empty(trim($concept->explanation ?? ''));
        $current = $isEmpty ? '(No explanation provided — generate one from scratch)' : $concept->explanation;

        $instruction = $isEmpty
            ? "Generate a concise, solid definition (2-3 short sentences max) for this concept. Cover what it is and why it matters for interviews."
            : "Rewrite this as a concise, solid definition (2-3 short sentences max).";

        return <<<PROMPT
Concept: {$concept->title}
Difficulty: {$concept->difficulty->value}
Current explanation:
{$current}

{$instruction}
PROMPT;
    }

    public function buildImproveConceptExplanationMessages(Concept $concept): array
    {
        return [
            ['role' => 'system', 'content' => $this->buildImproveConceptExplanationSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildImproveConceptExplanationUserPrompt($concept)],
        ];
    }

    protected function buildGenerateConceptExplanationSystemPrompt(): string
    {
        return <<<'PROMPT'
You are a technical education expert writing concept explanations for an interview preparation app.

First, check if the concept title is a valid technical term related to the given domain. Be lenient with typos — attempt to interpret what the user meant (e.g., "type castng" → "Type Casting", "routng" → "Routing"). Only reject if the input is truly gibberish, random characters, or completely unrelated to the domain.

If rejected, return: {"error": "invalid", "message": "The concept title is not valid or not related to this domain."}

If valid, generate a concise, solid definition (2-3 short sentences max). Cover what it is and why it matters for interviews. Do not add long examples, history, or unnecessary details. Keep it tight and focused.

Return ONLY a valid JSON object. Either:
{"error": "invalid", "message": "..."}
OR
{"explanation": "Your explanation here"}
PROMPT;
    }

    protected function buildGenerateConceptExplanationUserPrompt(string $title, string $domainName, string $difficulty): string
    {
        return <<<PROMPT
Domain: {$domainName}
Concept: {$title}
Difficulty: {$difficulty}

Generate a concise, solid definition (2-3 short sentences max). Cover what it is and why it matters for interviews.
PROMPT;
    }

    public function buildGenerateConceptExplanationMessages(string $title, string $domainName, string $difficulty): array
    {
        return [
            ['role' => 'system', 'content' => $this->buildGenerateConceptExplanationSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildGenerateConceptExplanationUserPrompt($title, $domainName, $difficulty)],
        ];
    }

    protected function buildVerifyConceptTitleSystemPrompt(): string
    {
        return <<<'PROMPT'
You are a technical education expert validating concept titles for an interview preparation app.

Check if the given concept title is a valid technical term related to the domain. Be lenient with typos — detect what the user likely meant.

Return ONLY a valid JSON object with one of these structures:
1. If valid and correctly spelled: {"valid": true}
2. If valid but has a typo: {"valid": false, "suggestion": "Corrected Title", "message": "Did you mean 'Corrected Title'?"}
3. If gibberish or unrelated: {"valid": false, "message": "This doesn't appear to be a valid technical concept for this domain."}
PROMPT;
    }

    protected function buildVerifyConceptTitleUserPrompt(string $title, string $domainName): string
    {
        return <<<PROMPT
Domain: {$domainName}
Concept title to verify: {$title}

Check if this is a valid technical concept for this domain. If there's a typo, suggest the correct spelling.
PROMPT;
    }

    public function buildVerifyConceptTitleMessages(string $title, string $domainName): array
    {
        return [
            ['role' => 'system', 'content' => $this->buildVerifyConceptTitleSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildVerifyConceptTitleUserPrompt($title, $domainName)],
        ];
    }
}
